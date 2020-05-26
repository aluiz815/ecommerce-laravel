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
use App\Pedido;
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

    public function checkout($pedidoId)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(\Cart::session(auth()->id())->getTotal());
        $amount->setCurrency('BRL');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        //$transaction->setDescription('')
        $callbackUrl = url('paypal/status',compact('pedidoId'));
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
    public function status(Request $request,$pedidoId)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');
        if(!$paymentId || !$payerId || !$token ){
            $statusError = "Uma Pena Pagamento com paypal error";
            return redirect()->route('paypal.failed')->with(compact('statusError'));
        }
        $payment = Payment::get($paymentId,$this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution,$this->apiContext);

        if($result->getState() === 'approved'){
            $statusAprovado = "Parabens, compra realizada com sucesso, Obrigado por confiar e volte sempre";
            $pedido = Pedido::find($pedidoId);
            $pedido->esta_pago = 1;
            $pedido->save();
            return redirect('results')->with(compact('statusAprovado'));
        }
        $statusError = "Uma Pena Pagamento com paypal error";
        return redirect('results')->with(compact('statusError'));
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
