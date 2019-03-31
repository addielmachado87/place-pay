<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePayment;
use App\Repository\BuyerRepository;
use App\Services\PayService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function index(Request $request)
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
            Log::critical($exception->getMessage());
            $request->session()->flash('error', $exception->getMessage());
            return redirect('/');
        }
    }

    public function list(PayService $payService,Request $request)
    {
        try {
            $payService->updatePaymentInfo();
            $payments = $payService->listPayment();
            if ($payments) {
                return view('payment.list', ['payments' => $payments]);
            }
            return redirect('/');
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            $request->session()->flash('error', $exception->getMessage());
            return redirect('/');
        }

    }
}
