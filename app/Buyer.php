<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    /**
     *  Table name
     */
    protected $table = 'buyers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document',
        'document_type',
        'name',
        'surname',
        'email',
        'movile',
        'address',
        'city',
        'country',
        'created_at'
    ];

    public function sessions()
    {
        return $this->hasMany('App\Session', 'session_id');
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'movile' => $this->movile,
            'address' => [
                "street" => $this->address,
                "city" => $this->city,
                "country" => $this->country,
            ],
            'city' => $this->address,
            'document' => $this->document,
            'documentType' => $this->document_type,
        ];
    }
}
