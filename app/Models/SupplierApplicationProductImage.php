<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApplicationProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_application_product_id',
        'image_path',
        'alt_text',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(SupplierApplicationProduct::class, 'supplier_application_product_id');
    }
}
