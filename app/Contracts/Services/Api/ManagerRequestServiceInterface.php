<?php

namespace App\Contracts\Services\Api;

interface ManagerRequestServiceInterface
{
    public function approve($id);
    public function update($id, $data);
    public function adminRequest($params);
    public function rejectRequest($id);
}
