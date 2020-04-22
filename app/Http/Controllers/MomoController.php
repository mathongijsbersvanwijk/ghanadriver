<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\MomoService;
use App\Services\PaymentService;
use Bmatovu\MtnMomo\Products\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MomoController extends Controller {
    public function momo() {
        return view('momo.requesttopay');
    }
    
    public function momoCheckout() {
        $amount = '123.75';
        
        return view('momo.requesttopay', compact('amount'));
    }
    
    public function momoRequestToPay(Request $request, PaymentService $pms, MomoService $mos) {
        $pay = new Payment();
        $pay->amount = $request->input('amount');
        $pay->payer_message = 'Payment requested from client '.$request->input('name');
        $pay->payee_note = 'Payment for DVLA registration';
        $pay->status = 'PENDING';
        $pay = $pms->saveNew($pay, $request->input('dvaId'));
        
        $col = new Collection();
        $momoTransactionId = $mos->requestToPay($col, $pay->transaction_id, Auth::user()->telephone, $pay->amount,
            $pay->payer_message, $pay->payee_note);

        $result = $mos->getTransactionStatus($col, $momoTransactionId);
        
        //TODO: parse result and get finTransactionId status reason
        
        $pay->momo_transaction_id = $momoTransactionId;
        $pay->financial_transaction_id = $finTransactionId;
        $pay->status = $status;
        $pay->reason = $reason;
        $pay = $pms->update($pay);
        
        return view('momo.requesttopayresp', compact('transactionId', 'momoTransactionId', 'result'));
    }
    
    public function momoCallback() {
        
        // TODO: if ok then $pay->status = 'SUCCESSFUL';
        
        
    }
    

}
