<?php

namespace App\Repositories;

use App\Contracts\Repositories\StatusRepositoryInterface;
use App\Models\Status;

class StatusRepository extends BaseRepository implements StatusRepositoryInterface
{
    /**
     * StatusRepository constructor.
     * @param Status $status
     */
    public function __construct(Status $status)
    {
        parent::__construct($status);
    }
}
