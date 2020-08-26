<?php
namespace App\Business;

use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use App\Support\Helpers\Utils;
use Illuminate\Support\Collection;

class PredefinedTest extends Test {

	public function __construct($tstId, TestConfigurationService $tcfs, TestQuestionService $tqs) {
	    $this->tcf = $tcfs->find($tstId);
    	$this->makeTest($tqs);
	}

	private function makeTest(TestQuestionService $tqs) {
		$lqueIds = new Collection();
		$ltqu = $tqs->findByTest($this->tcf->id); 
		foreach ($ltqu as $tqu) {
		    if ($tqu->refersToQuestion->status == 'APPROVED') {
		        $lqueIds->push($tqu->que_id);
		    }
		}
		$this->queIds = Utils::itemsArray($lqueIds);
		//dd($this->queIds);
	}
}	