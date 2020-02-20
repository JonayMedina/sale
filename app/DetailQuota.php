<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailQuota extends Model
{
    protected $fillable = [
        'quota_id', 'product_id', 'quantity', 'price', 'description'
    ];

    protected $guarded = ['id'];

    public function quotas ()
    {
        return $this->belongsTo(Quota::class);
    }

    public function product ()
    {
        return $this->hasMany(Product::class);
    }

    public $timestamps = false;
}
