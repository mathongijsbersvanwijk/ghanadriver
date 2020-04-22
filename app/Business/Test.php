<?php
namespace App\Business;

abstract class Test {
	protected $tcf;
	protected $queIds;
	
	public function getTcf() {
		return $this->tcf;
	}

	public function getQueIds() {
		return $this->queIds;
	}
}	




