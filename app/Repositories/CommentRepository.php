<?php

namespace App\Repositories;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     * @param Comment $comment
     */
    
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }
}
