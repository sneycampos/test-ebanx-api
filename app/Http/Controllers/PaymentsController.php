<?php

namespace App\Http\Controllers;

use Ebanx\Ebanx;
use App\Models\Plan;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;

class PaymentsController extends Controller
{
    public function __construct()
    {
        /**
         * Token de teste
         * Gerar token e armazenar em .env
         * Obter por env('EBANX_INTEGRATIONKEY'), por exemplo
         */

        \Ebanx\Config::set(array(
            'integrationKey' => 'test_ik_gByZFs3m9v3BMnU5RGgMXQ',
            'testMode' => true,
            'directMode' => true
        ));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout($id)
    {
        $plan = Plan::find($id);

        return view('checkout', compact('plan'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(Request $request)
    {
        $data = $request->all();

        $plan = Plan::find($data['plan_id']);

        $payment = \Ebanx\Ebanx::doRequest([
            'mode' => 'full',
            'operation' => 'request',
            'payment' => [
                'name'          => $data['name'],
                'email'         => $data['email'],
                'document'      => $data['document'],
                'address'       => $data['address'],
                'street_number' => $data['street_number'],
                'city'          => $data['city'],
                'state'         => $data['state'],
                'zipcode'       => $data['zipcode'],
                'country'       => $data['country'],
                'phone_number'  => $data['phone_number'],

                /**
                 * [payment_type_code]
                 * TO-DO: implementar função de capturar bandeira do cartão no front-end conforme os números setados (visa/diners/elo/hipercard/mastercard)
                 */
                'payment_type_code' => $data["payment_type_code"] == 'credit' || $data["payment_type_code"] == 'debit' ? 'visa' : 'boleto',

                'card' => [
                    'card_number'   => isset($data["creditcard"]["card_number"]) ? $data["creditcard"]["card_number"] : '',
                    'card_name'     => isset($data["creditcard"]["card_name"]) ? $data["creditcard"]["card_name"] : '',
                    'card_due_date' => isset($data["creditcard"]["card_due_date"]) ? $data["creditcard"]["card_due_date"] : '',
                    'card_cvv'      => isset($data["creditcard"]["card_cvv"]) ? $data["creditcard"]["card_cvv"] : ''
                ],

                'merchant_payment_code' => strtoupper(str_random(10) . uniqid(time())),
                'currency_code'         => 'BRL',
                'amount_total'          => $plan->price
            ]
        ]);

        if ($payment->status === 'SUCCESS') {
            $is_card = $data['payment_type_code'] === 'credit' ? true : false;

            if ($is_card) {
                if ($payment->payment->transaction_status->code === 'OK') {
                    //Pagamento por cartão efetuado com sucesso
                    return response()->json(['success' => true, 'message' => 'Pagamento realizado!<br>' . $payment->payment->transaction_status->description]);
                } else {
                    //Erro ao processar pagamento por cartão
                    return response()->json(['error' => true, 'message' => $payment->payment->transaction_status->description]);
                }
            } else {
                //Pagamento por boleto
                return response()->json(['success' => true, 'boleto_url' => $payment->payment->boleto_url]);
            }
        } else if ($payment->status === 'ERROR') {
            return response()->json(['error' => true, 'message' => $payment->status_message]);
        }
    }
}
