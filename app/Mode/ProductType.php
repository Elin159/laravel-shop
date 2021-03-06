<?php

namespace App\Mode;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';

    public $timestamps = false;

    protected $fillable = [
        'id','name','parent_id','path'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
