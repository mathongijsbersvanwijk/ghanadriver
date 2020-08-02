<?php
namespace App\Services;

use App\Models\Question;
use App\Models\TestConfiguration;
use App\Models\TestQuestion;
use Illuminate\Support\Facades\DB;

class TestConfigurationService {

	public function findAll() {
		return TestConfiguration::all();
	}
	
	public function find($id) {
		return TestConfiguration::find($id);
	}

	public function findAllByUser($user) {
	    return TestConfiguration::where('user_id', $user->id)->get();
	}
	
	public function save($untypedArr, $user) {
	    $tcf = new TestConfiguration();
	    return $this->saveTestConfiguration($untypedArr, $tcf, $user);
	}
	
	public function update($untypedArr, $user) {
	    $tcf = new TestConfiguration();
	    $tcf->exists = true;
	    return $this->saveTestConfiguration($untypedArr, $tcf, $user);
	}
	
    public function saveTestConfiguration($untypedArr, $tcf, $user) {
        DB::transaction(function () use ($untypedArr, $tcf, $user) {
    	    $tcf->id = isset($untypedArr['id']) ? $untypedArr['id'] : null;
    	    $tcf->tst_type = 'T';
    	    $tcf->tst_description = $untypedArr['desc'];
    	    $tcf->tst_count_tqu = 10; //$untypedArr['tst_count_tqu'];
    	    $tcf->tst_count_min_success = 9; //$untypedArr['tst_count_min_success'];
    	    $tcf->owner()->associate($user);
    	    $tcf->save();
    	    
    	    if ($tcf->id != null) {
    	        TestQuestion::where("test_id", $tcf->id)->delete();
    	    }
        
    	    $idArr = $untypedArr['dqids'];
    	    $ques = Question::whereIn('id', $idArr)->get();
    	    $tquArr = array();
    	    for ($i = 0; $i < sizeof($idArr); $i++) {
    	        $que = $ques->where('id', $idArr[$i])->first();
    	        $tqu = new TestQuestion(['test_id' => $tcf->id, 'question_id' => $idArr[$i], 'que_id' => $que->que_id, 'seq_id' => $i + 1]);
    	        $tquArr[] = $tqu;
    	    }
    	    $tcf->questions()->saveMany($tquArr);
        });
        
	    return $tcf;
	}
}