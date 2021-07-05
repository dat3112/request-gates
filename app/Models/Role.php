<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
