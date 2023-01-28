<?php

namespace App\Classes;

use App\Exceptions\ResponseException;

use Illuminate\Support\Facades\Http;

class Paystar
{
    public $gateway_id;
    public $create_url;
    public $secret_key;
    public $verify_url;
    public $payment_url;
    public $description;
    public $callback_url;

    public static $ok_status = 1;

    public function __construct()
    {
        $this->gateway_id = config('services.paystar.gateway_id');
        $this->callback_url = route('checkout.callback');
        $this->create_url = config('services.paystar.create_url');
        $this->secret_key = config('services.paystar.secret_key');
        $this->payment_url = config("services.paystar.payment_url");
        $this->verify_url = config("services.paystar.verify_url");
    }



    public function create($amount, $order_id, callable $callback = null)
    {
        $response = Http::withToken($this->gateway_id)->post(
            $this->create_url,
            [
                'amount' => $amount,
                'order_id' => $order_id,
                'callback' => $this->callback_url,
                'sign' => $this->createSignedData([$amount, $order_id, $this->callback_url]),
                'card_number' => auth()->user()->credit_card_number
            ]
        );

        $body = $response->json();

        if ($response->failed() or $body['status'] != self::$ok_status) {
            throw new ResponseException($body['message'], $body['data']);
        }

        if ($callback) {
            $callback($body['data']);
        }

        return redirect()->away($this->createGateWay($body['data']['token']));
    }

    private function createSignedData($data)
    {
        return hash_hmac('SHA512', implode('#', $data), $this->secret_key);
    }

    private function createGateWay($toekn): string
    {
        return $this->payment_url . '?token=' . $toekn;
    }

    public function callback($status, $data)
    {
        if ($status == self::$ok_status) {
            $this->verify($data);
        } else {
            throw new ResponseException('failed');
        }
    }

    public function verify($data)
    {
        $response = Http::withToken($this->gateway_id)->post(
            $this->verify_url,
            [
                'ref_num' => $data['ref_num'],
                'sign' => $this->createSignedData([$data['amount'], $data['ref_num'], $data['card_number'], $data['tracking_code']]),
                'amount' => $data['amount'],
            ]
        );

        $body = $response->json();
        if ($response->failed() or $body['status'] != self::$ok_status) {
            throw new ResponseException($body['message'], $body['data']);
        }
    }
}
