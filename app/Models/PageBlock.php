<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_page_id',
        'block_type_id',
        'content',
        'settings',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the product page that owns the block.
     */
    public function productPage()
    {
        return $this->belongsTo(ProductPage::class);
    }

    /**
     * Get the block type for this block.
     */
    public function blockType()
    {
        return $this->belongsTo(PageBlockType::class, 'block_type_id');
    }

    /**
     * Scope a query to only include active blocks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
