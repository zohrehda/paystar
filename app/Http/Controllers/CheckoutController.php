<?php

namespace App\Http\Controllers;

use App\Classes\Paystar;
use App\Exceptions\ResponseException;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $order = auth()->user()->currentOrder() ?: Order::factory()->create(['user_id' => auth()->id()]);
        return view('checkout.index', compact('order'));
    }

    public function checkout(CheckoutRequest $request)
    {
        $order = auth()->user()->currentOrder();

        $order->update([
            'status' => Order::$shipped_status
        ]);

        try {
            $paystar = new Paystar();
            return  $paystar->create($order->product->amount, $order->id, function ($data) {
                Transaction::create([
                    'ref_num' => $data['ref_num'],
                    'order_id' => $data['order_id'],
                    'amount' => $data['payment_amount']
                ]);
            });
        } catch (ResponseException $e) {
            $order->update([
                'status' => Order::$failed_status
            ]);
            return redirect()->back()->with(['message' => $e->getMessage()])->withErrors($e->getData(), 'system');
        }
    }

    public function callback(Request $request)
    {
        $status = $request->input('status');
        $transaction = Transaction::where('ref_num', $request->input('ref_num'))->first();
        abort_unless($transaction, 404);
        $transaction->update([
            'tracking_code' => $request->input('tracking_code'),
            'card_number' => $request->input('card_number'),
            'transaction_id' => $request->input('transaction_id'),
            'status' => $request->input('status'),
        ]);

        try {
            $paystar = new Paystar();
            $paystar->callback($status, [
                'amount' => $transaction->amount,
                'ref_num' => $transaction->ref_num,
                'transaction_id' => $transaction->transaction_id,
                'card_number' => $transaction->card_number,
                'tracking_code' => $transaction->tracking_code,
            ]);
            $transaction->update([
                'success' => true
            ]);

            $transaction->order()->update([
                'status' => Order::$success_status
            ]);

            Sale::create([
                'user_id' => auth()->id(),
                'product_id' => $transaction->order->product_id
            ]);
        } catch (ResponseException $e) {

            $transaction->order()->update([
                'status' => Order::$failed_status
            ]);

            return redirect()->route('checkout.status', ['transaction_id' => $transaction->transaction_id])
                ->with(['message' => $e->getMessage()]);
        }

        return redirect()->route('checkout.status', ['transaction_id' => $transaction->transaction_id]);
    }

    public function status($transaction_id)
    {
        $transaction =  Transaction::where('transaction_id', $transaction_id)->first();
        abort_unless($transaction, 404);
        return view('checkout.status', compact('transaction'));
    }
}
