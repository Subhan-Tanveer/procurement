<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBlockType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'component_name',
        'category',
        'description',
        'preview_image',
        'schema',
        'default_data',
        'is_active',
    ];

    protected $casts = [
        'schema' => 'array',
        'default_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the page blocks using this block type.
     */
    public function pageBlocks()
    {
        return $this->hasMany(PageBlock::class, 'block_type_id');
    }

    /**
     * Scope a query to only include active block types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
