<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\DvlaApplicationService;
use App\Services\MomoService;
use App\Services\PaymentService;
use Bmatovu\MtnMomo\Products\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MomoController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function momoDvlaForm() {
        
        return view('momo.dvlaform');
    }
    
    public function momoCheckout(Request $request, DvlaApplicationService $das) {
        //note: Eloquent create will also save to db, Eloquent firstOrCreate will query db first; both we do not want
        $dva = $das->create($request->all());
        $request->session()->put('dva', $dva);
        
        //TODO calculate amount
        $amount = "100";
        $request->session()->put('amount', $amount);
        
        return view('momo.checkout', compact('dva', 'amount'));
    }
    
    public function momoRequestToPay(Request $request, DvlaApplicationService $das, PaymentService $pms, MomoService $mos) {
        $dva = $request->session()->get('dva');
        $dva = $das->saveNew($dva);
        
        $pay = new Payment();
        $pay->amount = $request->session()->get('amount');
        $pay->payer_message = 'Payment requested from client '.$request->input('name');
        $pay->payee_note = 'Payment for DVLA registration';
        $pay->status = 'PENDING';
        $pay = $pms->saveNew($pay, $dva);
        
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
        
        return view('momo.rtpresponse', compact('transactionId', 'momoTransactionId', 'result'));
    }
    
    public function momoCallback() {
        
        // TODO: if ok then $pay->status = 'SUCCESSFUL';
        
        
    }
    

}
