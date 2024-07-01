<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct() {
        $paypalConfig = config('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );

        // dd($this->apiContext);
        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function showPaymentForm($id)
    {
        //OBTENER EL ID DEL CARRITO Y LISTAR PARA EL TOTAL
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $product) {
            $total = $total + $product['price'];
        }
        //PASAR EL ID DEL CARRITO
        return view('payments.index', compact('total'));
    }

    public function processCard(Request $request)
    {
        // OBTENER EL CARRITO PARA GUARDAR EN LA BASE DE DATOS
        try {
            Stripe::setApiKey(config('stripe.sk'));

            $totalprice = $request->get('total');
            $two0 = "00";
            $total = "$totalprice$two0";

            $session = Session::create([
                'line_items'  => [
                    [
                        [
                            'price_data' => [
                                'currency'     => 'USD',
                                'product_data' => [
                                    "name" => '-',
                                ],
                                'unit_amount'  => $total,
                            ],
                            'quantity'   => 1,
                        ]
                    ],

                ],
                'mode'        => 'payment',
                'success_url' => route('payment.success'),
                'cancel_url'  => route('payment.form', 1),
            ]);
            //GUARDAR EN LA BASE DE DATOS. LOS DATOS DEL PAGO Y EL METODO
            return redirect()->away($session->url);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function processPaypal(Request $request)
    {
        $validate = $request->validate([
            'total'
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->total);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        // $transaction->setDescription('See your IQ results');

        $callbackUrl = route('payment.paypal.status');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            // dd($this->apiContext);
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function processQr(Request $request)
    {
        $validate = $request->validate([
            'total'
        ]);
        return redirect()->route('payment.success');
    }
    public function paypal_status(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
            return redirect()->route('payments.form')->with(compact('status'));
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            return redirect()->route('payment.success')->with(compact('status'));
        }
        //El cliente cancelo
        return redirect()->route('payment.success')->with(compact('status'));
    }

    public function success()
    {
        return view('payments.success');
    }


}
