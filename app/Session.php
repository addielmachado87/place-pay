<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     *  Table name
     */
    protected $table = 'sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','process_url','created_at'];

    public function payers()
    {
        return $this->belongsTo('App\Buyer','buyer_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment','payment_id');
    }
}
