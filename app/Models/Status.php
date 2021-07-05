<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];
    
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
