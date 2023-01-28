<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'product_id',
        'user_id',
        'status'
    ];

    public static $pending_status = 'pending';
    public static $shipped_status = 'shipped';
    public static $success_status = 'success';
    public static $failed_status = 'failed';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
