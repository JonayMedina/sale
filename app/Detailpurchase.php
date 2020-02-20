<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailpurchase extends Model
{
    protected $fillable = [
    	'purchase_id', 'product_id', 'quantity', 'price'
    ];

    protected $guarded = ['id'];

     public function sales ()
    {
    	return $this->belongsTo(Sale::class);
    }

    public function product ()
    {
    	return $this->hasMany(Product::class);
    }

    public $timestamps = false;
}