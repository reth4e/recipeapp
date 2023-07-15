<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function message() {
        return $this->belongsTo('App\Models\Message');
    }
}
