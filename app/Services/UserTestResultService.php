<?php
namespace App\Services;

use App\Models\UserTestResult;

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