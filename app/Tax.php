<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['tax'];

    protected $guarded = ['id'];

    public function product ()
    {
    	return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
    	return $this->belongsTo(Purchase::class);
    }
    public function retention()
    {
        return $this->belongsTo(Retention::class);
    }

}
