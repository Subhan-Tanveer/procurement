<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'contact_name',
        'contact_email',
        'contact_phone',
        'organization_name',
        'slug',
        'category',
        'business_address',
        'business_phone',
        'website',
        'description',
        'logo',
        'status',
        'submitted_at',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
        'approved_supplier_profile_id',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (SupplierApplication $application) {
            if (empty($application->application_number)) {
                $year = now()->format('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $application->application_number = 'SUP-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(SupplierApplicationProduct::class)->orderBy('id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedSupplierProfile()
    {
        return $this->belongsTo(SupplierProfile::class, 'approved_supplier_profile_id');
    }
}
