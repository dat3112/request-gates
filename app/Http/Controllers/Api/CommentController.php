<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Contracts\Services\Api\CommentServiceInterface;

class CommentController extends ApiController
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $request, CommentServiceInterface $commentService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($commentService, $params) {
            return $commentService->store($params);
        });
    }

    public function show($id, CommentServiceInterface $commentService)
    {
        return $this->getData(function () use ($commentService, $id) {
            return $commentService->show($id);
        });
    }
}
