<?php

namespace App\Contracts\Services\Api;

interface CategoryServiceInterface
{
    public function index($params);
    public function detail($id);
    public function store($params);
    public function update($params, $id);
}
