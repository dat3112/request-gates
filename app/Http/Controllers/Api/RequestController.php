<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Contracts\Services\Api\ManagerRequestServiceInterface;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Http\Requests\Api\Requests\FillRequest;
use App\Http\Requests\Api\Requests\UpdateRequestAdmin;
use App\Http\Requests\Api\Requests\CreateRequest;
use App\Http\Requests\Api\Requests\UpdateRequest;
use App\Http\Requests\Api\Requests\ApproveRequest;

class RequestController extends ApiController
{
    protected $requestService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function index(FillRequest $request, RequestServiceInterface $requestService)
    {
        $params = $request->all();
        return $this->getData(function () use ($requestService, $params) {
            return $requestService->index($params);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, RequestServiceInterface $requestService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($requestService, $data) {
            return $requestService->store($data);
        });
    }

    public function detail($id, RequestServiceInterface $requestService)
    {
        return $this->getData(function () use ($requestService, $id) {
            return $requestService->detail($id);
        });
    }

    public function update(UpdateRequest $request, $id, RequestServiceInterface $requestService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($requestService, $id, $data) {
            return $requestService->update($id, $data);
        });
    }

    public function updateAdmin(
        $id,
        UpdateRequestAdmin $request,
        ManagerRequestServiceInterface $managerRequestService
    ) {
        $data = $request->all();
        return $this->doRequest(function () use ($managerRequestService, $id, $data) {
            return $managerRequestService->update($id, $data);
        });
    }

    public function destroy($id, RequestServiceInterface $requestService)
    {
        return $this->doRequest(function () use ($requestService, $id) {
            return $requestService->delete($id);
        });
    }

    public function approve($id, ManagerRequestServiceInterface $managerRequestService)
    {
        return $this->getData(function () use ($managerRequestService, $id) {
            return $managerRequestService->approve($id);
        });
    }

    public function myRequest(RequestServiceInterface $requestService)
    {
        return $this->getData(function () use ($requestService) {
            return $requestService->myRequest();
        });
    }

    public function showDepartmentRequest(RequestServiceInterface $requestService)
    {
        return $this->getData(function () use ($requestService) {
            return $requestService->showDepartmentRequest();
        });
    }

    public function adminRequest(Request $request, ManagerRequestServiceInterface $managerRequestService)
    {
        $params = $request->all();
        return $this->getData(function () use ($managerRequestService, $params) {
            return $managerRequestService->adminRequest($params);
        });
    }

    public function rejectRequest($id, ManagerRequestServiceInterface $managerRequestService)
    {
        return $this->getData(function () use ($managerRequestService, $id) {
            return $managerRequestService->rejectRequest($id);
        });
    }
}
