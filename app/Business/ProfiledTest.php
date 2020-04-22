<?php
namespace App\Business;

use Exception;
use Illuminate\Support\Collection;
use App\Services\TestConfigurationService;
use App\Services\ProfileCategoryService;
use App\Support\Helpers\Utils;
use App\Services\QuestionService;

class ProfiledTest extends Test {

	public function __construct($tstId, TestConfigurationService $tcfs, ProfileCategoryService $pcs, QuestionService $qs) {
		$this->tcf = $tcfs->find(['companyId' => 10131, 'tst_id' => $tstId]);
		$this->makeTest($pcs, $qs);
	}

	private function makeTest(ProfileCategoryService $pcs, QuestionService $qs) { 
		$lqueIds = $this->generateTest($this->tcf->pro_id, $this->tcf->tst_count_tqu, $pcs, $qs); 
		$this->queIds = Utils::itemsArray($lqueIds);
	}

	private function generateTest($proId, $countQue, ProfileCategoryService $pcs, QuestionService $qs) {
		$lqueIds = new Collection(); 
		$lpc = $pcs->findByProfile($proId);
		foreach ($lpc as $pc) {
			$lqas = $qs->findBySingleCategory($pc->cat_id);
			if (sizeof($lqas) <= $pc->par_abs) {
				throw new Exception("too few questions for category " . $pc->cat_id);
			}
			for ($i = 0; $i < $pc->par_abs; $i++) {
				$j = 0;
				while ($j < 100) {
					$k = rand(0, sizeof($lqas) - 1);
					$quePicked = $lqas[$k]->queid;
					if (!$lqueIds->contains($quePicked)) {
						$lqueIds->push($quePicked); 
						break;
					}
					$j++;
				}
				if ($j == 100) {
					throw new Exception("picking questions failed for category " . $pc->cat_id);
				}
			}
		}
	
		return $lqueIds->shuffle();
	}
}	