<?php

namespace App\Mode;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameter';

    protected $fillable = [
        'product_id', 'attr_value'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getAttrValueAttribute($value)
    {
        return json_decode($value, true);
    }
}
