<?php
namespace App\Services;

use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;
use Bmatovu\MtnMomo\Products\Collection;

class MomoService {
	public function requestToPay($col, $transactionId, $partyId, $amount, $payerMessage, $payeeNote) {
	    try {
	        //TODO: save this payment in GD with status PENDING or REQUEST
	        
	        $momoTransactionId = $col->requestToPay($transactionId, $partyId, $amount, $payerMessage, $payeeNote);
	        return $momoTransactionId;
	    } catch(CollectionRequestException $e) {
	        $this->printErrors($e);
	        //TODO: return proper message with payment data 
	        return null;
	    }
	}

	public function getTransactionStatus($col, $momoTransactionId) {
	    try {
	        return $col->getTransactionStatus($momoTransactionId);
	    } catch(CollectionRequestException $e) {
	        $this->printErrors($e);
	        return null;
	    }
	}
	    
	public function isActive($partyId, $partyIdType = null) {
	    try {
	        $col = new Collection();
	        return $col->isActive($partyId, $partyIdType);
	    } catch(CollectionRequestException $e) {
	        $this->printErrors($e);
	    }
	}
	
	public function getAccountBalance() {
	    try {
	        $col = new Collection();
	        return $col->getAccountBalance();
	    } catch(CollectionRequestException $e) {
	        $this->printErrors($e);
	    }
	}
	
	private function printErrors(CollectionRequestException $e) {
	    do {
	        //Log::error("MTN MoMo failed", ['file' => $e->getFile(), etc etc $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e)]);
	        printf("\n\r%s:%d %s (%d) [%s]\n\r", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
	    } while($e = $e->getPrevious());
	}
}