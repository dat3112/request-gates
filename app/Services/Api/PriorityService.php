<?php

namespace App\Services\Api;

use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Contracts\Services\Api\PriorityServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PriorityService extends AbstractService implements PriorityServiceInterface
{
    /**
     * @var PriorityRepositoryInterface
     */
    protected $priorityRepository;

    /**
     * PriorityService constructor.
     * @param PriorityRepositoryInterface $priorityRepository
     */
    public function __construct(PriorityRepositoryInterface $priorityRepository)
    {
        $this->priorityRepository = $priorityRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index()
    {
        if (!Redis::exists('priority')) {
            $priority = $this->priorityRepository->getColumns()->get();
            Redis::set('priority', $priority);
        }
        return json_decode(Redis::get('priority'));
    }
}
