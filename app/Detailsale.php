<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailsale extends Model
{
    protected $fillable = [
    	'sale_id', 'product_id', 'quantity', 'price', 'description'
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
 