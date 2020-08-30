<?php
namespace App\Business;

class CountUserTestResult {
    private $desc;
    private $name;
    private $total;
	
	public function __construct($desc, $name, $total) {
	    $this->desc = $desc;
	    $this->name = $name;
	    $this->total = $total;
	}
	
	public function getDesc() {
	    return $this->desc;
	}
	
	public function getName() {
	    return $this->name;
	}
	
	public function getTotal() {
		return $this->total;
	}
}	




