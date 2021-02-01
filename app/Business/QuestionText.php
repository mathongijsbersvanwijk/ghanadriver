<?php 
namespace App\Business;

class QuestionText {
	protected $medId;
	protected $medType;
	protected $tekContents;
	
	/**
	 * @return mixed
	 */
	public function getMedId() {
		return $this->medId;
	}

	/**
	 * @return mixed
	 */
	public function getMedType() {
		return $this->medType;
	}

	/**
	 * @return mixed
	 */
	public function getTekContents() {
		return $this->tekContents;
	}

	/**
	 * @param mixed $medId
	 */
	public function setMedId($medId) {
		$this->medId = $medId;
	}

	/**
	 * @param mixed $medType
	 */
	public function setMedType($medType) {
		$this->medType = $medType;
	}

	/**
	 * @param mixed $tekContents
	 */
	public function setTekContents($tekContents) {
		$this->tekContents = $tekContents;
	}

	public function toJson() {
	    $data = array(
	        "tekContents" => $this->tekContents
	    );
	    
	    return $data;
	}
}
