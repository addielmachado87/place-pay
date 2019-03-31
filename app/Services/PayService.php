<?php
/**
 * Created by PhpStorm.
 * User: addiel
 * Date: 29/03/19
 * Time: 15:01
 */

namespace App\Services;


use App\Payment;
use App\Session;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class PayService
{
    private $clientHttp;
    private $urlBase;
    private $header;
    private $identifier;
    private $secretKey;

    public function __construct(GuzzleService $clientHttp, $url_base, $identifier, $secretKey)
    {
        $this->clientHttp = $clientHttp;
        $this->urlBase = $url_base;
        $this->identifier = $identifier;
        $this->secretKey = $secretKey;

        $this->header = [
            'headers' => [
                'Content-Type' => 'application/json',

            ]
        ];
    }

    public function createSession($buyer, $amount)
    {
        try {
            $result = $this->makeSession($buyer->toArray(), $amount);
            if ($result['status'] == 'OK') {
                $data = $result['result'];
                $buyer->save();
                Session::where('active', true)->update(['active' => false]);
                $session = new Session();
                $session->process_url = $data['processUrl'];
                $session->request_id = $data['requestId'];
                $session->payers()->associate($buyer);
                $session->active = true;
                $session->save();
                return $session;
            }

        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return null;
        }

    }


    public function updatePaymentInfo()
    {
        try {
            $session = Session::where('active', true)->first();
            $url = $this->urlBase . '/api/session/' . $session->request_id;
            $auth = $this->buidAuthData();
            $result = $this->sendRequest($url, ['auth' => $auth], 'post');
            if ($result['status'] == 'OK') {
                $data = $result['result'];
                if ($data['payment'] != null) {
                    foreach ($data['payment'] as $item) {
                        $payment_info = [
                            'reference' => $item['reference'],
                        ];
                        $payment = $this->updatePayment($item['status'], $item['amount']['from'], $payment_info);
                        if ($payment) {
                            $payment->sessions()->associate($session);
                            $payment->save();
                        }
                    }
                }
                if ($data['request'] != null) {
                    $request = $data['request'];
                    $payment_info = $request['payment'];
                    $payment = $this->updatePayment($data['status'], $payment_info['amount'], $payment_info);
                    if ($payment) {
                        $payment->sessions()->associate($session);
                        $payment->save();
                    }
                }
                return $data;
            }
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return null;
        }
    }

    public function listPayment()
    {
        return Payment::with('sessions')->has('sessions')->paginate(10);;
    }


    //Create Request for payment
    public
    function makeSession($buyer, $amount)
    {
        $url = $this->urlBase . '/api/session';
        $auth = $this->buidAuthData();
        $expiration = Carbon::now()->addMinutes(60)->toIso8601String();
        $reference = time();
        $returnUrl = 'http://localhost:5100/place-pay/public/return/' . $reference;
        $body = $this->makeBody($buyer, $auth, $reference, $amount, $expiration, $returnUrl);
        return $this->sendRequest($url, $body, 'post');
    }

    // build Autenticate data for Request
    private
    function buidAuthData()
    {
        $seed = Carbon::now()->toIso8601String();
        $nonce = $this->getNonce();
        $nonceBase64 = base64_encode($nonce);
        $tranKey = base64_encode(sha1($nonce . $seed . $this->secretKey, true));
        return [
            'login' => $this->identifier,
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey
        ];

    }

//Generate Nonce code
    private
    function getNonce()
    {
        $nonce = '';
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        return $nonce;
    }

// send request with guzzle http client
    private
    function sendRequest($url, $params = null, $metod = 'get')
    {
        if ($metod == 'get')
            $response = $this->clientHttp->makeGetRequest($url, $this->header, $params);
        elseif ($metod == 'post')
            $response = $this->clientHttp->makePostRequest($url, $this->header, $params);

        if ($response['status'] == 'OK') {
            $result = json_decode($response['data'], true);
            return ['status' => 'OK', 'result' => $result];
        }
        return ['status' => 'error', 'result' => []];
    }

    private function makeBody($buyer, $auth, $reference, $amount, $expiration, $returnUrl)
    {
        return [
            'auth' => $auth,
            'buyer' => $buyer,
            'payment' => [
                'reference' => $reference,
                'description' => 'Pago básico de prueba',
                'amount' => $amount,
            ],
            'expiration' => $expiration,
            'returnUrl' => $returnUrl,
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        ];

    }

    private function updatePayment($status, $amount, $payment_info)
    {

        $payment = Payment::where('reference', $payment_info['reference'])->first();
        if (!$payment) {
            $payment = new Payment();
            $payment->s_status = $status['status'];
            $payment->s_message = $status['message'];
            $payment->s_reason = $status['reason'];
            $payment->s_date = Carbon::now();
            $payment->reference = $payment_info['reference'];
            $payment->description = $payment_info['description'];
            $payment->amount_currency = $amount['currency'];
            $payment->amount_total = $amount['total'];
            return $payment;
        }
        if ($payment->s_status != $status['status']) {
            $payment->s_status = $status['status'];
            return $payment;
        }
        return null;
    }

}