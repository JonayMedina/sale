<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'condition'];

    protected $guarded = ['id'];

    public $timestamps = false; 

    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
 