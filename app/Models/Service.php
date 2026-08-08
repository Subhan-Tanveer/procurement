<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image',
        'short_description',
        'description',
        'why_choose_title',
        'why_choose_intro',
        'why_choose_theme',
        'why_choose_features',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'why_choose_features' => 'array',
    ];

    /**
     * Get the details for the service.
     */
    public function details()
    {
        return $this->hasMany(ServiceDetail::class)->orderBy('sort_order');
    }

    /**
     * Get the products for the service.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
