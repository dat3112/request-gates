<?php

namespace App\Contracts\Services\Api;

interface HistoryRequestServiceInterface
{
    public function store($data_history);
    public function index($params);
}
