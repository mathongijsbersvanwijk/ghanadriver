<?php 
namespace App\Business;

class QuestionImage {
	protected $medId;
	protected $medType;
	protected $grfFileName;

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
	public function getGrfFileName() {
		return $this->grfFileName;
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
	 * @param mixed $grfFileName
	 */
	public function setGrfFileName($grfFileName) {
		$this->grfFileName = $grfFileName;
	}

	public function toJson() {
	    $data = array(
	        "grfFileName" => $this->grfFileName
	    );
	    
	    return $data;
	}
}
