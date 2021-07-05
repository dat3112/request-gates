<?php

namespace App\Repositories;

use App\Contracts\Repositories\HistoryRequestRepositoryInterface;
use App\Models\HistoryRequest;

class HistoryRequestRepository extends BaseRepository implements HistoryRequestRepositoryInterface
{
    /**
     * HistoryRequestRepository constructor.
     * @param HistoryRequest $historyrequest
     */
    
    public function __construct(HistoryRequest $historyRequest)
    {
        parent::__construct($historyRequest);
    }
}
