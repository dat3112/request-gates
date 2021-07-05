<?php

namespace App\Contracts\Services\Api;

interface RequestServiceInterface
{
    public function index($params);
    public function store($data);
    public function detail($id);
    public function update($id, $data);
    public function delete($id);
    public function myRequest();
    public function showDepartmentRequest();
}
