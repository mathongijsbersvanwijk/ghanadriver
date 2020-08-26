<?php
namespace App\Services;

use App\Models\Question;
use App\Models\TestConfiguration;
use App\Models\TestQuestion;
use App\Support\Helpers\Utils;
use Illuminate\Support\Facades\DB;

class TestConfigurationService {

	public function findAll() {
		return TestConfiguration::all();
	}
	
	public function findAllPredefined() {
	    return TestConfiguration::where('pro_id', 0)->get();
	    //return TestConfiguration::where('pro_id', 0)->withCount('questions')->get();
	}
	
	public function findAllByUser($user) {
        return TestConfiguration::where('user_id', $user->id)->get();
    }

    public function findAllByQuestion($id) {
        $ltqu = TestQuestion::where('question_id', $id)->get();
        $testidarr = Utils::testidArray($ltqu);
        $ltcf = TestConfiguration::whereIn('id', $testidarr)->get();
        
        // very weird, the result here below contains nulls for 'questions', wheras the elements should not be there at all
//      $ltcf = TestConfiguration::with(['questions' => function ($query) {
//             $query->where('que_id', 3308);
// 	    }])->get();
	    
	    return $ltcf;
	}
	
	public function findApprovedQuestions($tst_id) {
	    $ltqu = TestQuestion::where('test_id', $tst_id)->with(['refersToQuestion' => function ($query) {
	        $query->where('status', 'APPROVED');
	    }])->get();
	    
	    // very weird, the result above contains nulls for 'refersToQuestion', wheras the elements should not be there at all
	    return $ltqu->reject(function($tqu) {
	        return $tqu->refersToQuestion == null;
	    });
	}
	
	public function find($id) {
	    return TestConfiguration::find($id);
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
            $idArr = $untypedArr['dqids'];
            
            $tcf->id = isset($untypedArr['id']) ? $untypedArr['id'] : null;
    	    $tcf->pro_id = 0;
    	    $tcf->tst_type = 'T';
    	    $tcf->tst_description = $untypedArr['desc'];
    	    $tcf->tst_count_tqu = sizeof($idArr); // todo: count the number of approved questions below and update this
    	    $tcf->tst_count_min_success = sizeof($idArr) - 1;
    	    $tcf->owner()->associate($user);
    	    $tcf->save();
    	    
    	    if ($tcf->id != null) {
    	        TestQuestion::where("test_id", $tcf->id)->delete();
    	    }
        
    	    $ques = Question::whereIn('id', $idArr)->get();
    	    $tquArr = array();
    	    for ($i = 0; $i < sizeof($idArr); $i++) {
    	        $que = $ques->where('id', $idArr[$i])->first();
    	        if ($que->status == "APPROVED") {
    	            $tqu = new TestQuestion(['test_id' => $tcf->id, 'question_id' => $idArr[$i], 'que_id' => $que->que_id, 'seq_id' => $i + 1]);
    	            $tquArr[] = $tqu;
    	        }
    	    }
    	    $tcf->questions()->saveMany($tquArr);
        });
        
	    return $tcf;
	}

	// NOT USED
	public function removeUploadedQuestion($id) {
	    $ltcf = $this->findAllByQuestion($id);
	    foreach ($ltcf as $tcf) {
	        $ltqu = $this->findApprovedQuestions($tcf->id);
	        
	        TestQuestion::where("test_id", $tcf->id)->delete();
	        
	        foreach ($tcf->questions as $tqu) {
	            
	        }
	        $tcf->tst_count_tqu = 0;
	    }
	}
	
	public function delete($test) {
	    $test->questions()->delete();
	    $test->delete();
	}
}