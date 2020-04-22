<?php
namespace App\Business;

class UserTestQuestionAnswer {
	protected $dqa;

    public function __construct($dqa) {
    	$this->dqa = $dqa;	
	}

	public function getDisplayQuestionAlternative() {
		return $this->dqa;
	}

}	
