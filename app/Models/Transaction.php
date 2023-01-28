<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $fillable = [
        'amount',
        'ref_num',
        'order_id',
        'transaction_id',
        'status',
        'card_number',
        'tracking_code',
        'success'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
