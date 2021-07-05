<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name', 'author_id', 'content', 'category_id',
        'due_date', 'assign_id', 'status_id', 'priority_id', 'approve_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function approve()
    {
        return $this->belongsTo(User::class, 'approve_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function historyRequests()
    {
        return $this->hasMany(HistoryRequest::class);
    }
}
