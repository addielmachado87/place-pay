<?php
/**
 * Created by PhpStorm.
 * User: addiel
 * Date: 30/03/19
 * Time: 21:51
 */

namespace App\Repository;


use App\Buyer;
use Illuminate\Support\Facades\Log;

class BuyerRepository
{
    public static function createBuyer($data)
    {
        try {
            $buyer = new Buyer();
            $buyer->name = $data['name'];
            $buyer->surname = $data['surname'];
            $buyer->email = $data['email'];
            $buyer->movile = $data['movile'];
            $buyer->address = $data['address'];
            $buyer->city = $data['city'];
            $buyer->country = $data['country'];
            $buyer->document = $data['document'];
            $buyer->document_type = $data['document_type'];
            $buyer->save();
            return $buyer;
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return null;
        }


    }
}