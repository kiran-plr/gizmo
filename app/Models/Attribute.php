<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'attribute_family_id',
        'attribute_question',
        'description',
    ];

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, ProductAttribute::class, 'attribute_id', 'attribute_value_id');
    }

    public function productAttribute()
    {
        return $this->hasOne(ProductAttribute::class, 'attribute_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, ProductAttribute::class);
    }

    public function attributeFamily()
    {
        return $this->belongsTo(AttributeFamily::class);
    }

    public static function getAttr($value)
    {
        return Attribute::where('slug', $value)->first();
    }
}
