<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Services\Api\CommentServiceInterface;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Exceptions\CheckAuthorizationException;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;

class CommentService extends AbstractService implements CommentServiceInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository,
        RequestRepositoryInterface $requestRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function store($params)
    {
        $userID=Auth::user()->id;
        $params['user_id']=$userID;
        $this->commentRepository->store($params);
        return [
            'message' => config('constants.COMMENT.STORE.SUCCESS')
        ];
    }
    
    public function show($id)
    {
        return [
            'comments' => $this->commentRepository->getColumns(['*'], ['user'])->where('request_id', $id)->get(),
        ];
    }
}
