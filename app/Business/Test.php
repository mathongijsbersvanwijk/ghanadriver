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
	
	public function toJson() {
	    $data = array(
	        "pro_id" => $this->tcf->pro_id,
	        "tst_type" => $this->tcf->tst_type,
	        "tst_description" => $this->tcf->tst_description,
	        "tst_count_tqu" => $this->tcf->tst_count_tqu,
	        "tst_count_min_success" => $this->tcf->tst_count_min_success
	    );
	
	    return $data;	    
	}
}	




