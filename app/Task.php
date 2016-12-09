<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'url',
    ];

    public function assignee()
    {
        return $this->belongsToMany(User::class, 'task_assign');
    }
}
