<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     *  Table name
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['s_status','s_reason','s_message','s_date','return_url','ip_adress','reference','description','amount_currency','amount_total','allow_partial','created_at'];


    public function sessions()
    {
        return $this->belongsTo('App\Session','session_id');
    }
}
