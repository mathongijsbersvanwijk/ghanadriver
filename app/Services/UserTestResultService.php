<?php
namespace App\Services;

use App\Business\CountUserTestResult;
use App\Models\UserTestResult;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserTestResultService {
	public function findAll() {
		return UserTestResult::all();
	}

	public function find($id) {
		return UserTestResult::findOrFail($id);
	}

	public function findByName($name) {
		return UserTestResult::where('name', $name)->first();
	}
	
	public function findAllByName($nameArr) {
		return UserTestResult::whereIn('name', $nameArr)->get();
	}
	
	public function countResultsPerTest() {
	    $loa = $this->countResults();
	    $lcutr = new Collection();
	    if ($loa != null && sizeof($loa) > 0) {
	        $i = 0;
	        while ($i < sizeof($loa)) {
	            $cutr = new CountUserTestResult($loa[$i]->descr, $loa[$i]->name, $loa[$i]->total);
	            $lcutr->push($cutr);
	            $i++;
	        }
	    }
	    
	    return $lcutr;
	}
	
	private function countResults() {
	    $loa = DB::select(DB::raw(
	        "SELECT tst_description as descr, name, count(exa_id) as total ". 
            "FROM quagga_examination ".
	        "LEFT JOIN quagga_test t ON tst_id = t.id ".
	        "LEFT JOIN users u ON user_id = u.id ".
	        "WHERE tst_id != 3 GROUP by tst_id ORDER BY tst_id ASC"
        ));
	    
	    return $loa;
	}
	
	public function saveUserTestResult($utr, $userId, $tstId, $proId, $countCorrect, $mode) {
		if ($utr == null) {
			$utr = new UserTestResult();
			$utr->exists = false;
		} else {
			$utr->exists = true;
		}
		$utr->prs_id = $userId;
		$utr->tst_id = $tstId;
		$utr->pro_id = $proId;
		$utr->exa_date_taken = gmdate('Y-m-d H:i:s');
		$utr->exa_count_tqu_correct = $countCorrect;
		$utr->exa_mode = $mode;
		$utr->save();
				
		return $utr;
	}
}