<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'name', 'crawler', 'config',
    ];

    protected $casts = [
        'config' => 'json',
    ];
}
