<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_company',
        'subject',
        'message',
        'status',
        'total_amount',
        'currency',
        'notes',
        'valid_until',
        'responded_at',
        'paid_at',
        'approved_by',
        'rejected_by',
        'paid_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'valid_until' => 'date',
        'responded_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Boot the model and generate quote number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotation) {
            if (empty($quotation->quote_number)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $quotation->quote_number = 'QT-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get the items for the quotation.
     */
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
