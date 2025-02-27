<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdraws';
    protected $primaryKey = 'id';
    protected $fillable = [
        'phone',
        'address',
        'amount',
        'method',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(TgUser::class, 'phone', 'phone');
    }
}
