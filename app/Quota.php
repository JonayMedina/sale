<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $fillable = [
        'client_id', 'user_id','voucher_num', 'date', 'tax', 'total', 'status'
    ];

    protected $guarded = ['id'];

    public $timestamps = false;

    public function client ()
    {
        return $this->belongsTo(Client::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function detailquotas ()
    {
        return $this->hasMany(DetailQuota::class);
    }
}
