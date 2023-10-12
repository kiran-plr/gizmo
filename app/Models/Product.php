<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_id',
        'category_id',
        'attribute_family_id',
        'type',
        'sku',
        'name',
        'slug',
        'description',
        'price',
        'photos',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributesParentProduct()
    {
        return $this->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, ProductAttribute::class, 'product_id', 'attribute_value_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function skuMaxPrice()
    {
        return $this->skus()->max('price');
    }

    public function attributeFamily()
    {
        return $this->belongsTo(AttributeFamily::class);
    }

    public static function getCreateValidationRule($id)
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'attribute_family_id' => 'required|exists:attribute_families,id',
            'slug' => 'required|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:products,slug,' . $id,
            'name' => 'required|min:5,max:40',
            'description' => 'required|min:10,max:500',
        ];
    }

    public static function getCreateValidationMessage()
    {
        return [
            'category_id.required' => 'Please select category',
            'category_id.exists' => 'Ctegory not found',
            'brand_id.required' => 'Please select brand',
            'brand_id.exists' => 'Brand not found',
            'attribute_family_id.required' => 'Please select attribute family',
            'attribute_family_id.exists' => 'Attribute family not found',
            // 'type.required' => 'Please select type',
            // 'type.in' => 'Type not found',
            'slug.required' => 'Please enter slug',
            'slug.regex' => 'Slug must be smaller case and separated by dashes (-) and no white space',
            'slug.unique' => 'Slug already exists',
            'name.required' => 'Please enter name',
            'name.min' => 'Name must be at least 5 characters',
            'name.max' => 'Name must be less than 50 characters',
            'description.required' => 'Please enter description',
            'description.min' => 'Description must be at least 10 characters',
            'description.max' => 'Description must be less than 500 characters',
        ];
    }

    public static function getConfigurableRule()
    {
        return [
            'price' => 'required|numeric|between:1,99999.99',
            'retail_price' => 'required|numeric|between:1,99999.99',
            'status' => 'required|in:0,1',
        ];
    }

    public static function getConfigurableRuleMessage()
    {
        return [
            'price.required' => 'Please enter price',
            'price.numeric' => 'Price must be numeric',
            'price.between' => 'Price must be between 1 and 99999.99',
            'retail_price.required' => 'Please enter retail price',
            'retail_price.numeric' => 'Retail Price must be numeric',
            'retail_price.between' => 'Retail Price must be between 1 and 99999.99',
            'status.required' => 'Please select status',
            'status.in' => 'Status not found',
        ];
    }
}
