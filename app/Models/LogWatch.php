<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogWatch extends Model
{
    protected $table = 'log_watches';
    protected $guarded = [];
    protected $fillable = ['phone'];

    function user() {
        return $this->belongsTo(TgUser::class);
    }
}
