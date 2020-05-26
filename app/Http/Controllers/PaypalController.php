<?php

namespace App\Http\Controllers;

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use Darryldecode\Cart\Cart;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Config;

class PaypalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );
    }

    public function checkout()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(\Cart::session(auth()->id())->getTotal());
        $amount->setCurrency('BRL');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        //$transaction->setDescription('')
        $callbackUrl = url('paypal/status');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }
    public function status(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');
        if(!$paymentId || !$payerId || !$token ){
            $status = "Uma Pena Pagamento com paypal error";
            return redirect()->route('paypal.failed')->with(compact('status'));
        }
        $payment = Payment::get($paymentId,$this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution,$this->apiContext);

        if($result->getState() === 'approved'){
            $status = "Parabens Pagamento com paypal sucesso";
            return redirect('results')->with(compact('status'));
        }
        $status = "Uma Pena Pagamento com paypal error";
        return redirect('results')->with(compact('status'));
    }
    public function failed()
    {
        return view('results');
    }

    public function results()
    {
        return view('results');
    }
}
