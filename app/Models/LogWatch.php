<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogWatch extends Model
{
    protected $table = 'log_watches';
    protected $guarded = [];
    protected $fillable = ['phone', 'created_at', 'updated_at'];

    function user() {
        return $this->belongsTo(TgUser::class, 'phone', 'phone');
    }
}
