<?php
namespace App\Business;

class CountUserTestResult {
	private $desc;
	private $total;
	
	public function __construct($desc, $total) {
	    $this->desc = $desc;
	    $this->total = $total;
	}
	
	public function getDesc() {
		return $this->desc;
	}

	public function getTotal() {
		return $this->total;
	}
}	




