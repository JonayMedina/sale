<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'type', 'phone', 'email', 'rif', 'condition', 'retention', 'address'];

    protected $guarded = ['id'];

    public function provider()
    {
    	return $this->hasOne('Provider::class');
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }
    
}
