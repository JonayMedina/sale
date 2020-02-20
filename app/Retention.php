<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retention extends Model
{
    protected $filleble = ['voucher_num', 'date', 'year', 'month', 'tax', 'total', 'status'];

    protected $guarded = ['id'];

    public function purchases ()
    {
    	return $this->hasMany(Purchase::class);
    }
}
