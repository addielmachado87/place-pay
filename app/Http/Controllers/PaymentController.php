<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePayment;
use App\Repository\BuyerRepository;
use App\Services\PayService;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function create(CreatePayment $request, PayService $payService)
    {
        try {
            $data = $request->all();
            if ($data) {
                $buyer = BuyerRepository::createBuyer($data);
                if ($buyer) {
                    $session = $payService->createSession($buyer, ['currency' => $data['currency'], 'total' => $data['total']]);
                    if ($session) {
                        return Redirect::away($session->process_url);
                    }
                }
            }
        } catch (\Exception $exception) {
            return redirect('/');
        }
    }

    public function list(PayService $payService)
    {

        try {
            $payService->updatePaymentInfo();
            $payments = $payService->listPayment();
            if ($payments) {
                return view('payment.list', ['payments' => $payments]);
            }
        } catch (\Exception $exception) {

        }

    }
}
