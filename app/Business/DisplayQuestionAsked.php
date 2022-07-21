<?php
namespace App\Business;

class DisplayQuestionAsked {
	private $qt;
	private $qi;
	
    public function __construct() {
    	$this->qt = null;	
    	$this->qi = null;	
    }
	
	public function getQuestionText() {
		return $this->qt;
	}
		
	public function setQuestionText($questionText) {
		$this->qt = $questionText;
	}
	
	public function getQuestionImage() {
		return $this->qi;
	}
		
	public function setQuestionImage($questionImage) {
		$this->qi = $questionImage;
	}

	public function toJson() {
	    $data = array(
	        "qt" => $this->qt != null ? $this->qt->toJson() : null,
	        "qi" => $this->qi != null ? $this->qi->toJson() : null
	    );
	    
	    return $data;
	}
}	
