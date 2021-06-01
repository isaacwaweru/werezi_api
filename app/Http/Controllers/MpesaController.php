<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function confirmation(Request $request)
    {
        $response = json_decode($request->getContent(), true);

        Log::info('C2B Confirmation: ' . request()->ip());
        Log::info($response);

        $mpesa_transaction_id = $response['TransID'];

        if (!$mpesa_transaction_id) {

            $message = ["ResultCode" => 0, "ResultDesc" => "Success"];
            Log::info($message);

        }

        $this->updatePayment($response);

        $message = ["ResultCode" => 0, "ResultDesc" => "Success"];

        Log::info($message);
    }

    public function validation(Request $request)
    {
        return 1;
    }
    
    private function updatePayment($response)
    {
        $mpesa_transaction_id = $response['TransID'];
        $date_time = Carbon::parse($response['TransTime']);
        $amount = $response['TransAmount'];
        $account = strtoupper(preg_replace('/\s+/', '', $response['BillRefNumber']));
        $merchant_transaction_id = $response['ThirdPartyTransID'];
        $phone = $response['MSISDN'];
        $payer = preg_replace('!\s+!', ' ', ucwords(strtolower($response['FirstName'] . ' ' . $response['MiddleName'] . ' ' . $response['LastName'])));

        $exists = Payment::where('transaction_id', $mpesa_transaction_id)->count();

        if ($exists == 0) {
            $payment = Payment::create([
                'transaction_id' => $mpesa_transaction_id,
                'date_time' => $date_time,
                'amount' => $amount,
                'account' => $account,
                'phone' => $phone,
                'payer' => $payer,
            ]);
        }
    }
}
