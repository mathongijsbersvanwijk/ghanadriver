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
}	
