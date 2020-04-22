<?php
namespace App\Business;

use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use App\Support\Helpers\Utils;
use Illuminate\Support\Collection;

class PredefinedTest extends Test {

	public function __construct($tstId, TestConfigurationService $tcfs, TestQuestionService $tqs) {
		$this->tcf = $tcfs->find(['companyId' => 10131, 'tst_id' => $tstId]);
    	$this->makeTest($tqs);
	}

	private function makeTest(TestQuestionService $tqs) {
		$lqueIds = new Collection();
		$ltqu = $tqs->findByTest($this->tcf->tst_id); 
		foreach ($ltqu as $tqu) {
			$lqueIds->push($tqu->que_id);
		}
		$this->queIds = Utils::itemsArray($lqueIds);
		//dd($this->queIds);
	}
}	