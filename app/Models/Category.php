<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'user_id', 'status'
    ];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
