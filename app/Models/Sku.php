<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'retail_price',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, ProductAttribute::class, 'sku_id', 'attribute_id');
    }

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, ProductAttribute::class, 'attribute_id', 'attribute_value_id');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'sku_id');
    }
}
