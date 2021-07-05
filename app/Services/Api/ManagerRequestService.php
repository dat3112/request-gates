<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Repositories\HistoryRequestRepositoryInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Repositories\StatusRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\ManagerRequestServiceInterface;
use App\Exceptions\CheckAuthorizationException;
use App\Exceptions\QueryException;
use App\Services\AbstractService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;

class ManagerRequestService extends AbstractService implements ManagerRequestServiceInterface
{
    /**
     * @var RequestRepositoryInterface
     */
    protected $requestRepository;

    /**
     * RequestService constructor.
     * @param RequestRepositoryInterface $requestRepository
     */
    public function __construct(
        RequestRepositoryInterface $requestRepository,
        HistoryRequestRepositoryInterface $historyRequestRepository,
        StatusRepositoryInterface $statusRepository,
        UserRepositoryInterface $userRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository,
        RequestService $requestService
    ) {
        $this->requestRepository = $requestRepository;
        $this->statusRepository = $statusRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->historyRequestRepository = $historyRequestRepository;
        $this->commentRepository = $commentRepository;
        $this->requestService = $requestService;
    }

    /**
     * @param $params
     * @return array
     */

    public function approve($id)
    {
        $request=$this->requestRepository->find($id);//get info request
        $userId=Auth::user()->id;
        $isRoleDepartment=Auth::user()->department_id == $request->author->department_id &&
        Auth::user()->role_id == config('constants.ROLE.QLBP');
        $isCheckApprove = $request->approve_id == null;
        if (!($request->status_id == config('constants.STATUS.OPEN') &&
            $isCheckApprove &&
            ($userId == $request->assign_id || $isRoleDepartment))
        ) {
            throw new CheckAuthorizationException(config('constants.REQUEST.APPROVE.WARNING'));
        }
        $dataApprove['approve_id'] = $userId;
        if (Auth::user()->role_id == config('constants.ROLE.ADMIN')) {
            $dataApprove['status_id'] = config('constants.STATUS.PROGRESS');
        }
        if (!$this->requestRepository->find($id)->update($dataApprove)) {
            throw new QueryException(config('constants.REQUEST.APPROVE.ERROR'));
        }
        $paramsCreateComment=[
            'content' => config('constants.COMMENT.APPROVE_REQUEST'),
            'request_id' => $request->id,
            'user_id' => $userId
        ];
        $dataHistory=[
            'content' => config('constants.HISTORY_REQUEST.APPROVE_REQUEST'),
            'request_id' => $request->id,
            'user_id' => $userId
        ];
        $mail=[
            'view' => 'emails.requests.approve',
            'title' => config('constants.EMAIL.APPROVE_REQUEST'),
            'email' => [
                $request->author->email,
                $request->assign->email,
                Auth::user()->email
            ]
        ];
        $this->requestService->createComment($paramsCreateComment);
        $this->requestService->createHistory($dataHistory);
        $this->requestService->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.APPROVE.SUCCESS'),
        ];
    }

    public function update($id, $data)
    {
        $oldRequest=$this->requestRepository->find($id);
        $userId=Auth::user()->id;
        //Kiểm tra có update thành công hay không
        if (!$this->requestRepository->find($id)->update($data)) {
            throw new QueryException(config('constants.REQUEST.UPDATE.ERROR'));
        }
        $newRequest = $this->requestRepository->find($id);
        //Tạo content comment
        $contentComment = $this->deffRequestAdmin($oldRequest, $newRequest);
        if (empty($contentComment)) {
            throw new CheckAuthorizationException(config('constants.REQUEST.UPDATE.CHANGE'));
        }
        $paramsCreateComment=[
            'content' => json_encode($contentComment),
            'request_id' => $oldRequest->id,
            'user_id' => $userId,
        ];
        $dataHistory=[
            'content'=>config('constants.HISTORY_REQUEST.UPDATE_REQUEST'),
            'request_id'=> $newRequest->id,
            'user_id'=> $userId,
        ];
        $mail=[
            'view' => 'emails.requests.updateAdmin',
            'title' => config('constants.EMAIL.UPDATE.TITLE'),
            'content' => $contentComment,
            'email' => [
                $oldRequest->author->email,
                $newRequest->assign->email,
                $oldRequest->assign->email
            ]
        ];
        $this->requestService->createComment($paramsCreateComment);
        $this->requestService->createHistory($dataHistory);
        $this->requestService->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.UPDATE.SUCCESS'),
        ];
    }

    public function deffRequestAdmin($oldRequest, $newRequest)
    {
        $contentComment=[];
        if ($oldRequest->status_id != $newRequest->status_id) {
            $contentComment['status'] = "'{$oldRequest->status->name}' thành '{$newRequest->status->name}'";
        }
        if ($oldRequest->assign_id != $newRequest->assign_id) {
            $contentComment['assign'] = "'{$oldRequest->assign->name}' thành '{$newRequest->assign->name}'";
        }
        if ($oldRequest->priority_id != $newRequest->priority_id) {
            $contentComment['priority'] = "'{$oldRequest->priority->name}' thành '{$newRequest->priority->name}'";
        }
        return $contentComment;
    }

    public function adminRequest($params)
    {
        $userId=Auth::user()->id;
        return $this->requestRepository
            ->getColumns(['*'], ['author', 'category', 'assign', 'priority','approve', 'status'])
            ->where('assign_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($params['per_page'] ?? config('constants.PER_PAGE'));
    }

    public function rejectRequest($id)
    {
        $request=$this->requestRepository->find($id);//get info request
        $userId=Auth::user()->id;
        //Kiểm tra user có phải trưởng bộ phận của author hay không?
        $isRoleDepartment=Auth::user()->department_id == $request->author->department_id &&
        Auth::user()->role_id == config('constants.ROLE.QLBP');

        if (($request->status_id == config('constants.STATUS.CLOSE') &&
            ($userId == $request->assign_id || $isRoleDepartment))
        ) {
            throw new CheckAuthorizationException(config('constants.REQUEST.REJECT.WARNING'));
        }
        
        $dataApprove['status_id'] = config('constants.STATUS.CLOSE');
        if (!$this->requestRepository->find($id)->update($dataApprove)) {
            throw new QueryException(config('constants.REQUEST.REJECT.ERROR'));
        }
        $paramsCreateComment=[
            'content' => config('constants.COMMENT.REJECT_REQUEST'),
            'request_id' => $request->id,
            'user_id' => $userId
        ];
        $dataHistory=[
            'content' => config('constants.HISTORY_REQUEST.REJECT_REQUEST'),
            'request_id' => $request->id,
            'user_id' => $userId
        ];
        $mail=[
            'view' => 'emails.requests.reject',
            'title' => config('constants.EMAIL.REJECT_REQUEST'),
            'email' => [
                $request->author->email,
                $request->assign->email,
                Auth::user()->email
            ]
        ];
        $this->requestService->createComment($paramsCreateComment);
        $this->requestService->createHistory($dataHistory);
        $this->requestService->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.REJECT.SUCCESS'),
        ];
    }

    public function sendMailDueDate()
    {
        $nextDay = Carbon::now()->addDay(1);
        $requestDue = $this->requestRepository->listEmailAssign($nextDay)->toArray();
        $mail = [
            'view' => 'emails.requests.requestDue',
            'title' => config('constants.EMAIL.REQUEST_DUE'),
            'email' => $requestDue,
            'url' => env('APP_URL')
        ];
        Mail::to($mail['email'])
            ->queue(new SendMail($mail));
    }
}
