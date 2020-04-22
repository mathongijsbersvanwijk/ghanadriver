<?php 
namespace App\Business;

class QuestionImage {
	protected $medId;
	protected $medType;
	protected $grfFileName;

	//protected $table = 'quagga_graphic';
    //protected $primaryKey = array('med_id', 'med_type');
    //protected $fillable = ['med_id', 'med_type', 'grf_code', 'grf_filename'];

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
}
