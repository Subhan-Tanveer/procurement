<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'template_id',
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the product that owns the page.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the template for the page.
     */
    public function template()
    {
        return $this->belongsTo(PageTemplate::class, 'template_id');
    }

    /**
     * Get the blocks for the page.
     */
    public function blocks()
    {
        return $this->hasMany(PageBlock::class)->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get the user who created the page.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the page.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
