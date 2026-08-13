<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'previous_status',
        'remarks',
        'triggered_by',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}