<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\BookCopy;
use App\Models\Payment;
use Illuminate\Support\Str;
use SmoDav\Mpesa\Laravel\Facades\STK;
use SmoDav\Mpesa\Laravel\Facades\Registrar;

class OrdersController extends Controller
{
    public function index()
    {
        return Order::where('user_id', auth()->guard('api')->id())->get()->map(function($order) {
            return $order->parse();
        });
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'payment' => 'required',
            'books' => 'required',
            'address' => 'required'
        ]);

        $amount = 0;

        collect($request->books)->each(function($item) use(&$amount) {
            $the_item = BookCopy::findOrFail($item['id']);
            $amount += ($item['quantity'] * $the_item->price);
        });

        $order = Order::create([
            'user_id' => auth()->guard('api')->id(), 
            'name' => $request->name, 
            'phone_number' => $request->phone_number, 
            'address' => $request->address, 
            'payment' => $request->payment, 
            'status' => Order::STATUS['pending'], 
            'amount' => $amount,
            'reference' => $this->generateReference()
        ]);

        collect($request->books)->each(function($item) use($order) {
            $the_item = BookCopy::findOrFail($item['id']);

            $order->items()->create([
                'book_id' => $the_item->book_id, 
                'book_copy_id' => $item['id'], 
                'order_id' => $order->id, 
                'quantity' => $item['quantity'], 
                'price' => $the_item->price, 
                'total' => $item['quantity'] * $the_item->price
            ]);
        });

        $conf = 'https://admin.werezi.com/api/mobile/confirmation';
        $val = 'https://admin.werezi.com/api/mobile/validation';

        $response = Registrar::register(env('MPESA_SHORT_CODE'))
            ->onConfirmation($conf)
            ->onValidation($val)
            ->submit();

        return $order->reference;
    }

    private function generateReference()
    {
        $code = strtoupper(Str::random(6));

        if(Order::where('reference', $code)->exists()) {
            return $this->generateReference();
        }

        return $code;
    }

    public function show($ref)
    {
        $order = Order::where('reference', '=', $ref)->firstOrFail();

        return $order->parse();
    }

    public function pay($ref)
    {
        $order = Order::where('reference', '=', $ref)->firstOrFail();
        
        if(Payment::where('account', $order->reference)->exists()) {
            $payments = Payment::where('account', $order->reference)->get();

            if($order->amount >= $payments->sum('amount')) {
                $order->update([
                    'paid' => 1
                ]);

                return [
                    'paid' => 1,
                    'status' => 'paid'
                ];
            }

            return [
                'paid' => 2,
                'status' => 'partially paid',
                'expected' => $order->amount,
                'received' => $payments->sum('amount')
            ];
        }

        return [
            'paid' => 0,
            'status' => 'not paid'
        ];
    }

    public function getAmount($ref)
    {
        $order = Order::where('reference', $ref)->firstOrFail();

        return [
            'amount' => $order->amount
        ];
    }

    public function formatPhoneNumber($phone_number)
    {
        return '254' . substr($phone_number, -9);
    }

    public function requestStk(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'reference' => 'required'
        ]);

        $order = Order::where('reference', $request->reference)->firstOrFail();
        $phone_number = (int) $this->formatPhoneNumber($request->phone_number);
        $amount = $order->amount;

        $response = STK::request($amount)
            ->from($phone_number)
            ->usingReference($order->reference, 'Book Order')
            ->push();

        return 1;
    }
}
