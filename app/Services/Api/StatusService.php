<?php

namespace App\Services\Api;

use App\Contracts\Repositories\StatusRepositoryInterface;
use App\Contracts\Services\Api\StatusServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class StatusService extends AbstractService implements StatusServiceInterface
{
    /**
     * @var StatusRepositoryInterface
     */
    protected $statusRepository;

    /**
     * StatusService constructor.
     * @param StatusRepositoryInterface $userRepository
     */
    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index()
    {
        if (!Redis::exists('status')) {
            $status = $this->statusRepository->getColumns()->get();
            Redis::set('status', $status);
        }
        return json_decode(Redis::get('status'));
    }
}
