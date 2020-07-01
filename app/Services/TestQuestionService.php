<?php
namespace App\Services;

use App\Models\TestQuestion;

class TestQuestionService {
	public function findAll() {
		return TestQuestion::all();
	}

	public function find($id) {
		return TestQuestion::findOrFail($id);
	}

	public function findByTstId($tst_id) {
		return TestQuestion::where('tst_id', $tst_id)->get();
	}

// 	public function save($untypedArr) {
// 		$tq = new TestQuestion();
// 		$tq->tst_id = $untypedArr['tst_id'];
// 		$tq->seq_id = $untypedArr['seq_id'];
// 		$tq->que_id = $untypedArr['que_id'];
// 		$tq->save();
		
// 		return $tq;
// 	}
}