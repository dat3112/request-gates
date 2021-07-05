<?php

namespace App\Repositories;

use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Models\Priority;

class PriorityRepository extends BaseRepository implements PriorityRepositoryInterface
{
    /**
     * PriorityRepository constructor.
     * @param Priority $priority
     */
    public function __construct(Priority $priority)
    {
        parent::__construct($priority);
    }
}
