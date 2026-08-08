<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'service_id',
        'supplier_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'currency',
        'featured_image',
        'is_featured',
        'is_active',
        'stock_status',
        'sort_order',
        'meta_title',
        'meta_description',
        'approval_status',
        'approval_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get the service that owns the product.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the product page.
     */
    public function productPage()
    {
        return $this->hasOne(ProductPage::class);
    }

    /**
     * Get the specifications for the product.
     */
    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get the quotation items for the product.
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier_id');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeSupplierOwned($query)
    {
        return $query->whereNotNull('supplier_id');
    }

    public function scopeAdminOwned($query)
    {
        return $query->whereNull('supplier_id');
    }
}
