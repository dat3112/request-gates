<?php

namespace App\Contracts\Services\Api;

interface CommentServiceInterface
{
    public function store($params);
    public function show($id);
}
