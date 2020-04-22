<?php
namespace App\Http\Controllers;

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
        
        
        $transactionId = '12384875'; //Uuid::uuid4();
        $partyId = Auth::user()->telephone;
        $amount = $request->input('amount');
        $payerMessage = 'Payment requested from client '.$request->input('name');
        $payeeNote = 'Payment for DVLA registration';
        
        $col = new Collection();
        $momoTransactionId = $mos->requestToPay($col, $transactionId, $partyId, $amount, $payerMessage, $payeeNote);
        $result = $mos->getTransactionStatus($col, $momoTransactionId);
        
        return view('momo.requesttopayresp', compact('transactionId', 'momoTransactionId', 'result'));
    }
    
    public function momoCallback() {
        
        
        
    }
    

}
