<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'quotation_id',
        'assigned_to',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_company',
        'status',
        'total_amount',
        'currency',
        'notes',
        'delivery_address',
        'delivery_contact',
        'delivery_phone',
        'expected_delivery_at',
        'actual_delivery_at',
        'tracking_ref',
        'carrier',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'expected_delivery_at' => 'date',
        'actual_delivery_at' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $order->order_number = 'ORD-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
