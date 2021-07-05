<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Repositories\HistoryRequestRepositoryInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Repositories\StatusRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Exceptions\CheckAuthorizationException;
use App\Exceptions\QueryException;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;

class RequestService extends AbstractService implements RequestServiceInterface
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
        CommentRepositoryInterface $commentRepository
    ) {
        $this->requestRepository = $requestRepository;
        $this->statusRepository = $statusRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->historyRequestRepository = $historyRequestRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        if (empty($params)) {
            return $this->requestRepository->listRequest();
        } else {
            $param = [
                'name' => '',
                'content' => '',
                'created_at' => '',
                'status_id' => '',
                'author_id' => '',
                'assign_id' => '',
                'category_id' => '',
                'department_id' => ''
            ];
            $params = array_merge($param, $params);
            return $this->requestRepository->findRequest($params);
        }
    }

    public function store($data)
    {
        $data['author_id'] = Auth::user()->id;
        $newRequest = $this->requestRepository->store($data);
        if (!$newRequest) {
            throw new QueryException(config('constants.REQUEST.STORE.ERROR'));
        }
        $dataHistory = [
            'content' => config('constants.HISTORY_REQUEST.CREATE_REQUEST'),
            'request_id' => $newRequest->id,
            'user_id' => $data['author_id'],
        ];
        $mail = [
            'view' => 'emails.requests.create',
            'title' => config('constants.EMAIL.STORE.TITLE'),
            'content' => $data['content'],
            'authorName' => $newRequest->author->name,
            'assignName' => $newRequest->assign->name,
            'dueDate' => $data['due_date'],
            'requestName' => $data['name'],
            'email' => [
                $newRequest->author->email,
                $newRequest->assign->email
            ],
        ];
        $this->createHistory($dataHistory);
        $this->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.STORE.SUCCESS'),
        ];
    }

    public function detail($id)
    {
        return $this->requestRepository
            ->getColumns(['*'], ['author', 'category', 'assign', 'priority', 'approve', 'status'])
            ->where('id', $id)->get();
    }

    public function update($id, $data)
    {
        $oldRequest = $this->requestRepository->find($id); //get info old request
        $data['author_id'] = Auth::user()->id;
        $isRoleUpdateRequest = $oldRequest->status_id == config('constants.STATUS.OPEN') &&
            $data['author_id'] == $oldRequest->author_id && $oldRequest->approve_id == null;
        //Kiểm tra quyền chỉnh sửa
        if (!$isRoleUpdateRequest) {
            throw new CheckAuthorizationException(config('constants.REQUEST.UPDATE.WARNING'));
        }
        //Kiểm tra có update thành công hay không
        if (!$this->requestRepository->find($id)->update($data)) {
            throw new QueryException(config('constants.REQUEST.UPDATE.ERROR'));
        }
        //get info new request
        $newRequest = $this->requestRepository->find($id);
        //Tạo content comment
        $contentComment = $this->deffRequest($oldRequest, $newRequest);
        if (empty($contentComment)) {
            throw new CheckAuthorizationException(config('constants.REQUEST.UPDATE.CHANGE'));
        }
        $paramsCreateComment = [
            'content' => json_encode($contentComment),
            'request_id' => $oldRequest->id,
            'user_id' => $data['author_id']
        ];
        $dataHistory = [
            'content' => config('constants.HISTORY_REQUEST.UPDATE_REQUEST'),
            'request_id' => $newRequest->id,
            'user_id' => $data['author_id'],
        ];
        $mail = [
            'view' => 'emails.requests.update',
            'title' => config('constants.EMAIL.UPDATE.TITLE'),
            'content' => $contentComment,
            'email' => [
                $oldRequest->author->email,
                $newRequest->assign->email,
                $oldRequest->assign->email
            ]
        ];
        $this->createComment($paramsCreateComment);
        $this->createHistory($dataHistory);
        $this->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.UPDATE.SUCCESS'),
        ];
    }

    public function delete($id)
    {
        $request = $this->requestRepository->find($id); //get info request
        $userId = Auth::user()->id;
        //Kiểm tra quyền xoá
        $isRoleDeleteRequest = $request->status_id == config('constants.STATUS.OPEN') &&
            $userId == $request->author_id && $request->approve_id == null;
        if (!$isRoleDeleteRequest) {
            throw new CheckAuthorizationException(config('constants.REQUEST.DELETE.WARNING'));
        }
        if (!$this->requestRepository->destroy($this->requestRepository->find($id))) {
            throw new QueryException(config('constants.REQUEST.DELETE.ERROR'));
        }
        $dataHistory = [
            'content' => config('constants.HISTORY_REQUEST.DELETE_REQUEST'),
            'request_id' => $request->id,
            'user_id' => $userId,
        ];
        $mail = [
            'view' => 'emails.requests.delete',
            'title' => config('constants.EMAIL.DELETE.TITLE'),
            'email' => [
                $request->author->email,
                $request->assign->email
            ]
        ];
        $this->createHistory($dataHistory);
        $this->sendMail($mail);
        return [
            'message' => config('constants.REQUEST.DELETE.SUCCESS'),
        ];
    }

    public function myRequest()
    {
        $userId = Auth::user()->id;
        return $this->requestRepository
            ->getColumns(['*'], ['author', 'category', 'assign', 'priority', 'approve', 'status'])
            ->where('author_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    public function showDepartmentRequest()
    {
        $departmentID = Auth::user()->department_id;
        return $this->requestRepository->listRequestDepartment($departmentID);
    }

    //function kiểm tra sự thay đổi của request
    public function deffRequest($oldRequest, $newRequest)
    {
        $contentComment = [];
        if ($oldRequest->name != $newRequest->name) {
            if (mb_strlen($oldRequest->name) > 500 || mb_strlen($newRequest->name) > 500) {
                $contentComment['name'] =  config('constants.REQUEST.UPDATE.LONG_TEXT');
            } else {
                $contentComment['name'] = "'{$oldRequest->name}' thành '{$newRequest->name}'";
            }
        }

        if ($oldRequest->content != $newRequest->content) {
            if (mb_strlen($oldRequest->content) > 500 || mb_strlen($newRequest->content) > 500) {
                $contentComment['content'] =  config('constants.REQUEST.UPDATE.LONG_TEXT');
            } else {
                $contentComment['content'] = "'{$oldRequest->content}' thành '{$newRequest->content}'";
            }
        }

        if ($oldRequest->category_id != $newRequest->category_id) {
            $contentComment['category'] = "'{$oldRequest->category->name}' thành '{$newRequest->category->name}'";
        }

        if ($oldRequest->assign_id != $newRequest->assign_id) {
            $contentComment['assign'] = "'{$oldRequest->assign->name}' thành '{$newRequest->assign->name}'";
        }

        if ($oldRequest->priority_id != $newRequest->priority_id) {
            $contentComment['priority'] = "'{$oldRequest->priority->name}' thành '{$newRequest->priority->name}'";
        }

        if ($oldRequest->due_date != $newRequest->due_date) {
            $contentComment['due_date'] = "'{$oldRequest->due_date}' thành '{$newRequest->due_date}'";
        }

        return $contentComment;
    }

    public function createHistory($dataHistory)
    {
        if (!$this->historyRequestRepository->store($dataHistory)) {
            throw new QueryException(config('constants.ERROR'));
        }
    }

    public function createComment($params)
    {
        if (!$this->commentRepository->store($params)) {
            throw new QueryException(config('constants.ERROR'));
        }
    }

    public function sendMail($mail)
    {
        Mail::to($mail['email'])
            ->queue(new SendMail($mail));
    }
}
