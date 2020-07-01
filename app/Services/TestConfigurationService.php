<?php
namespace App\Services;

use App\Models\TestConfiguration;
use App\Models\TestQuestion;

class TestConfigurationService {

	public function findAll() {
		return TestConfiguration::all();
	}
	
	public function find($idArr) {
		return TestConfiguration::find($idArr);
	}

	public function findByTstId($tstId) {
	    return TestConfiguration::where('tst_id', $tstId)->first();
	}
	
	public function findAllByUser($user) {
	    return TestConfiguration::where('user_id', $user->id)->get();
	}
	
	public function save($untypedArr, $user) {
	    // todo: add transaction         
	    $tcf = new TestConfiguration();
	    $tcf->tst_type = 'T';
	    $tcf->tst_description = 'some test'; //$untypedArr['tst_description'];
	    $tcf->tst_count_tqu = 10; //$untypedArr['tst_count_tqu'];
	    $tcf->tst_count_min_success = 9; //$untypedArr['tst_count_min_success'];
	    $tcf->owner()->associate($user);
	    $tcf->save();
	    
	    $idArr = $untypedArr['ids'];
	    $tquArr = array();
	    for ($i = 0; $i < sizeof($idArr); $i++) {
	        $tqu = new TestQuestion(['test_id' => $tcf->id, 'question_id' => $idArr[$i], 'seq_id' => $i + 1]);
	        $tquArr[] = $tqu;
	    }
	    $tcf->questions()->saveMany($tquArr);
	    
	    return $tcf;
	}
	
/* 	public function findByPrimaryKey($companyId, $tst_id) {
		return TestConfiguration::where('companyId', $companyId)->where('tst_id', $tst_id)->first();
	}
 */
}