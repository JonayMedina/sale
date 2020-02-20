<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
	'code', 'name', 'stock', 'stock_min', 'stock_max', 'price_sell', 'description', 'price_buy', 'condition'
	];

	protected $guarded = ['id'];

	public function category(){
		return $this->belongsTo(Category::class);
	}
}
