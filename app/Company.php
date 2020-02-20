<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'type', 'phone', 'email', 'rif', 'address'];

    protected $guarded = ['id'];

    public function retention()
    {
        return $this->belongsTo(Retention::class);
    }

}
