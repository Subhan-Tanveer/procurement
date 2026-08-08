<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApplicationProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_application_id',
        'category_id',
        'service_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'currency',
        'stock_status',
        'featured_image',
        'status',
        'review_notes',
        'reviewed_by',
        'reviewed_at',
        'converted_product_id',
        'converted_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'reviewed_at' => 'datetime',
            'converted_at' => 'datetime',
        ];
    }

    public function application()
    {
        return $this->belongsTo(SupplierApplication::class, 'supplier_application_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function specifications()
    {
        return $this->hasMany(SupplierApplicationProductSpecification::class)->orderBy('sort_order');
    }

    public function images()
    {
        return $this->hasMany(SupplierApplicationProductImage::class)->orderBy('sort_order');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function convertedProduct()
    {
        return $this->belongsTo(Product::class, 'converted_product_id');
    }
}
