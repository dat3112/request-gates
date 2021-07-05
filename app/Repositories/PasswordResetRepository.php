<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Contracts\Repositories\PasswordResetRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    /**
     * PasswordResetRepository constructor.
     * @param PasswordReset $passwordreset
     */
    public function __construct(PasswordReset $passwordReset)
    {
        parent::__construct($passwordReset);
    }
    public function findCreateAtByEmail($param)
    {
        $email = $param['email'];
        $createdAt = PasswordReset::select('updated_at')->where('email', $email)->first();
        return  $createdAt;
    }
    public function updateByEmail($data)
    {
        return DB::table('password_resets')
            ->where('email', $data['email'])
            ->update(['token' => $data['token'], 'updated_at' => $data['created_at']]);
    }
    public function updatePassword($data)
    {
        return DB::table('users')
            ->where('email', $data['email'])
            ->update(['password' => bcrypt($data['newPassword'])]);
    }
    public function deleteResetRepository($data)
    {
        return DB::table('password_resets')
            ->where('email', $data['email'])
            ->delete();
    }
}
