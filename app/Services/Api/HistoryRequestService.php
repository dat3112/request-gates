<?php

namespace App\Services\Api;

use App\Contracts\Repositories\HistoryRequestRepositoryInterface;
use App\Contracts\Services\Api\HistoryRequestServiceInterface;
use App\Services\AbstractService;

class HistoryRequestService extends AbstractService implements HistoryRequestServiceInterface
{
    /**
     * @var HistoryRequestRepositoryInterface
     */
    protected $historyRequestRepository;

    /**
     * HistoryRequestService constructor.
     * @param HistoryRequestRepositoryInterface $historyRequestRepository
     */
    public function __construct(HistoryRequestRepositoryInterface $historyRequestRepository)
    {
        $this->historyRequestRepository = $historyRequestRepository;
    }

    public function store($data)
    {
        return $this->historyRequestRepository->store($data);
    }
    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        $data=[
            'per_page'=>10,
        ];
        $params = array_merge($data, $params);
        return $this->historyRequestRepository
                    ->getColumns(['*'], ['user', 'request'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($params['per_page']);
    }
}
