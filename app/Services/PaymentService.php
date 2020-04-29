<?php
namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;

class PaymentService
{
    public function findAll() {
        return Payment::all();
    }

    public function find($id) {
        return Payment::findOrFail($id);
    }

    public function findAfterDate($date = null) {
        if ($date == null) {
            $date = Carbon::now();
        }

        //TODO finetune for time
        return Payment::where('created_at', '>', $date)->get();
    }

    public function create($untypedArr) {
        $pay = new Payment();
        $pay->transaction_id = $untypedArr['transaction_id'];
        $pay->momo_transaction_id = $untypedArr['momo_transaction_id'];
        $pay->financial_transaction_id = $untypedArr['financial_transaction_id'];
        $pay->status = $untypedArr['status'];
        $pay->reason = $untypedArr['reason'];
        $pay->amount = $untypedArr['amount'];
        $pay->currency = $untypedArr['currency'];
        $pay->payer_message = $untypedArr['payer_message'];
        $pay->payee_note = $untypedArr['payee_note'];
        return $pay;
    }
    
    public function saveNew($pay, $dva) {
        $pay->dvlaApplication()->associate($dva);
        $pay->save();
        $pay->transaction_id = $pay->id;
        return $pay;
    }
        
    public function update($pay) {
        $pay->exists = true;
        $pay->save();
        return $pay;
    }
    
    public function saveNewRaw($untypedArr, $dva) {
        $pay = $this->create($untypedArr);
        $pay->dvlaApplication()->associate($dva);
        $pay->save();
        return $pay;
    }

    public function updateRaw($untypedArr, $dva) {
        $pay = $this->create($untypedArr);
        $pay->dvlaApplication()->associate($dva);
        $pay->exists = true;
        $pay->save();
        return $pay;
    }

/*    private function savePayment($pay, $untypedArr, $dva) {
        $pay->id = isset($untypedArr['id']) ? $untypedArr['id'] : null;
        $pay->transaction_id = $untypedArr[transaction_id];
        $pay->momo_transaction_id = $untypedArr['momo_transaction_id'];
        $pay->financial_transaction_id = $untypedArr['financial_transaction_id'];
        $pay->status = $untypedArr[status];
        $pay->reason = $untypedArr[reason];
        $pay->amount = $untypedArr[amount];
        $pay->currency = $untypedArr[currency];
        $pay->payer_message = $untypedArr[payer_message];
        $pay->payee_note = $untypedArr[payee_note];
        $pay->dvlaApplication()->associate($dva);
        $pay->save();

        return $pay;
    }
*/    
}
