<?php

namespace App\Http\Controllers\Api;

use App\HistoryRequest;
use Illuminate\Http\Request;
use App\Contracts\Services\Api\HistoryRequestServiceInterface;

class HistoryRequestController extends ApiController
{
    /**
     * HistoryRequestController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, HistoryRequestServiceInterface $historyRequestService)
    {
        $params = $request->all();
        return $this->getData(function () use ($historyRequestService, $params) {
            return $historyRequestService->index($params);
        });
    }
}
