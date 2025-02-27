<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TgUser extends Model
{
    protected $table = 'tg_users';
    protected $guarded = [];
    protected $fillable = [
        'phone',
        'first_name',
        'last_name',
        'username',
        'watched_ads_count',
        'earned_points',
        'total_withdraw',
        'status',
    ];


}
