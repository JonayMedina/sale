<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table ='purchases';
    protected $fillable = [
    	'provider_id', 'user_id','voucher', 'voucher_serial', 'voucher_num', 'date', 'tax', 'total', 'status'
    ];

    protected $guarded = ['id'];

    public function provider ()
    {
    	return $this->belongsTo(Provider::class);
    }

    public function user () {
    	return $this->belongsTo(User::class);
    }


}
 