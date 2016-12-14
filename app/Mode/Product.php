<?php

namespace App\Mode;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name', 'product_type_id', 'price', 'stock', 'describe',
        'is_up', 'sales', 'see_num', 'avatar'
    ];

    public function productType() {
        return $this->belongsTo(ProductType::class,'product_type_id', 'id');
    }

    public function parameter() {
        return $this->hasOne(Parameter::class);
    }
}
