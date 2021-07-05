<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Exceptions\QueryException;

class CheckStatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($request, Closure $next)
    {
        try {
            $statusUser=$this->userRepository->findByEmail($request->email)->status;
        } catch (\Throwable $th) {
            throw new QueryException(config('constants.LOGIN.ERROR'));
        }
        if ($statusUser == config('constants.USER.STATUS.ACTIVE')) {
            return $next($request);
        }

        return response()->json([
            'message' => config('constants.LOGIN.STATUS')
        ], 403);
    }
}
