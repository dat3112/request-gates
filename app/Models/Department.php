<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'department_code', 'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
