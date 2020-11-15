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
	    return TestConfiguration::where('pro_id', 0)->where('tst_count_tqu', '>', 0)->get();
	    //return TestConfiguration::where('pro_id', 0)->withCount('questions')->get();
	}
	
	public function findAllByUser($user) {
        return TestConfiguration::where('user_id', $user->id)->get();
    }

    public function findAllByQuestion($queId) {
        $ltqu = TestQuestion::where('que_id', $queId)->get();
        $testidarr = Utils::testidArray($ltqu);
        $ltcf = TestConfiguration::whereIn('id', $testidarr)->get();
        
        // very weird, the result here below contains nulls for 'questions', wheras the elements should not be there at all
//      $ltcf = TestConfiguration::with(['questions' => function ($query) {
//             $query->where('que_id', 3308);
// 	    }])->get();
	    
	    return $ltcf;
	}
	
	public function findApprovedQuestions($tstId) {
	    $ltqu = TestQuestion::where('tst_id', $tstId)->with(['refersToQuestion' => function ($query) {
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
    	    $tcf->tst_count_tqu = sizeof($idArr); 
    	    $tcf->tst_count_min_success = sizeof($idArr) - 1;
    	    $tcf->owner()->associate($user);
    	    $tcf->save();
    	    
    	    if ($tcf->id != null) {
    	        TestQuestion::where("tst_id", $tcf->id)->delete();
    	    }
        
    	    $ques = Question::whereIn('que_id', $idArr)->get();
    	    $tquArr = array();
    	    for ($i = 0; $i < sizeof($idArr); $i++) {
    	        $que = $ques->where('que_id', $idArr[$i])->first();
    	        if ($que->status == "APPROVED") {
    	            $tqu = new TestQuestion(['tst_id' => $tcf->id, 'que_id' => $que->que_id, 'seq_id' => $i + 1]);
    	            $tquArr[] = $tqu;
    	        }
    	    }
    	    $tcf->questions()->saveMany($tquArr);
        });
        
	    return $tcf;
	}

	public function updateQuestionInTestConfiguration($que, $id) {
	    DB::transaction(function () use ($que, $id) {
	        $tcf = TestConfiguration::findOrFail($id);
	        $i = $tcf->questions()->count();
	        $queInTest = $tcf->questions->contains(function($tqu, $key) use ($que) {
	            return $tqu->que_id == $que->id;
	        });
            if (!$queInTest) {
                $tqu = new TestQuestion(['tst_id' => $tcf->id, 'que_id' => $que->que_id, 'seq_id' => $i + 1]);
                $tqu->save();
            }
	        $this->correctTotalInTestsWithQuestion($que->id, true);
	    });
	}
	    
	public function correctTotalInTestsWithQuestion($queId, $increase) {
	    $ltcf = $this->findAllByQuestion($queId);
	    foreach ($ltcf as $tcf) {
	        if ($increase) {
	            $tcf->tst_count_tqu++;
	        } else {
	            $tcf->tst_count_tqu--;
	        }
	        $tcf->tst_count_min_success = $tcf->tst_count_tqu - 1;
	        $tcf->save();
	    }
	}
	
	public function delete($test) {
	    $test->questions()->delete();
	    $test->delete();
	}
}