<?php
namespace App\Services;

use App\Models\Categorization;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAlternative;
use App\Models\QuestionAsked;
use App\Models\QuestionImageResource;
use App\Models\QuestionTextResource;
use App\Support\Helpers\Utils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionService {
	public function findAll() {
		return Question::all();
	}
	
	public function find($id) {
	    return Question::findOrFail($id);
	}
	
	public function findByQueId($queId) {
	    return Question::where('que_id', $queId)->first();
	}
	
	public function findBySingleCategory($catId) {
		$cats = new Collection();
		$cat = new Category();
		$cat->id = $catId;
		$cats->push($cat);
		return $this->findByCategoryImpl($cats, 0, 0);
	}
	
	private function findByCategoryImpl($cats, $lastid, $limit) {
		if ($cats == null || ($cats != null && sizeof($cats) == 0)) {
			return new Collection();
		}
		$ca = Utils::idArray($cats);
		
		$lqas = DB::table('quagga_question')->select('quagga_question.que_id as queid');
		for ($i = 0; $i < sizeof($ca); $i++) {
			$lqas = $lqas
			->join('categorizations as c'.$i, function ($join) use ($ca, $i) {
				$join->on('c'.$i.'.categorizable_id', '=', 'quagga_question.id')
				->where('c'.$i.'.categorizable_type', '=', 'App\Models\Question')
				->where('c'.$i.'.category_id', '=', $ca[$i]);
			});
		}
		if ($limit > 0) {
			$lqas = $lqas->where('quagga_question.que_id', '>', $lastid)->take($limit)->get();
		} else {
			$lqas = $lqas->get();
		}
		
/* 		$quesnew = new Collection();
		for ($i = 0; $i < sizeof($ques); $i++) {
			$que = new Question();
			$que->que_id = $ques[$i]->queid;
			$quesnew->put($que->que_id, $que);
		}
 */		
		return $lqas;
	}
	
	public function findQuestionArtifacts($queId) {
 		$loa = DB::select(DB::raw(
			"SELECT pp.que_id, 'P' as type, pp.pop_id as seq, pp.med_id, pp.med_type, null as alt_correct, tk.tek_contents, grf.grf_filename " .
			"FROM quagga_pose_part pp " .
			"LEFT JOIN quagga_tekst tk ON pp.med_id = tk.med_id " .
			"LEFT JOIN quagga_graphic grf ON pp.med_id = grf.med_id " .
		 	"WHERE que_id = " . $queId .
			" UNION " .
			"SELECT alt.que_id, 'A' as type, alt.alt_id as seq, alt.med_id, alt.med_type, alt.alt_correct, tk.tek_contents, grf.grf_filename " .
			"FROM quagga_alternative alt " .
			"LEFT JOIN quagga_tekst tk ON alt.med_id = tk.med_id " .
			"LEFT JOIN quagga_graphic grf ON alt.med_id = grf.med_id " .
		 	"WHERE que_id = " . $queId .
		 	" UNION " .
			"SELECT ep.que_id, 'E' as type, '1', ep.med_id, ep.med_type, null, tk.tek_contents, grf.grf_filename " .
			"FROM quagga_expl_part ep " .
			"LEFT JOIN quagga_tekst tk ON ep.med_id = tk.med_id " .
			"LEFT JOIN quagga_graphic grf ON ep.med_id = grf.med_id " .
			"WHERE que_id = ". $queId
 		));
		
 		return $loa;		
	}

	public function findQuestionAskedArtifacts($userId) {
	    $loa = DB::select(DB::raw(
	        "SELECT pp.que_id, 'P' as type, pp.pop_id as seq, pp.med_id, pp.med_type, null as alt_correct, tk.tek_contents, grf.grf_filename " .
	        "FROM quagga_question q " .
	        "LEFT JOIN quagga_pose_part pp ON q.que_id = pp.que_id " .
	        "LEFT JOIN quagga_tekst tk ON pp.med_id = tk.med_id " .
	        "LEFT JOIN quagga_graphic grf ON pp.med_id = grf.med_id " .
	        "WHERE q.user_id = ". $userId
	        ));
	    
	    return $loa;
	}
	
	public function findQuestionMetaData($queId) {
		$loa = DB::select(DB::raw(
			"SELECT dm.doc_id, mv.value " .
			"FROM quagga_doc_meta dm, quagga_metavalue mv " .
			"WHERE dm.id_metavalue = mv.id_metavalue and mv.id_metavar = 10 and doc_id = ". $queId
		));
		
		return $loa;
	}
		
	public function saveQuestion($qt, $qi, $ldqalt, $user = null) {
	    $que = new Question();
	    DB::transaction(function () use ($que, $qi, $qt, $ldqalt, $user) {
	        $maxQueId = DB::table('quagga_question')->max('que_id'); // should be > 10000
	        $que->que_id = $maxQueId + 1;
	        $que->owner()->associate($user == null ? Auth::user() : $user);
	        $que->save();
	        
	        $qtr = new QuestionTextResource();
	        $maxMedtxtId = DB::table('quagga_tekst')->max('med_id');
	        $qtr->med_id = $maxMedtxtId + 1;
	        $qtr->med_type = $qt->getMedType();
	        $qtr->tek_contents = $qt->getTekContents();
	        $qtr->save();
	        
	        $qask = new QuestionAsked();
	        $qask->que_id = $que->que_id;
	        $qask->pop_id = 1;
	        $qask->med_id = $qtr->med_id;
	        $qask->med_type = $qtr->med_type;
	        $qask->save();
	        
	        $qir = new QuestionImageResource();
	        $maxMedgrfId = DB::table('quagga_graphic')->max('med_id');
	        $qir->med_id = $maxMedgrfId + 1;
	        $qir->med_type = $qi->getMedType();
	        $qir->grf_filename = $que->que_id."_".$qi->getGrfFileName();
	        $qir->save();
	        
	        $qask = new QuestionAsked();
	        $qask->que_id = $que->que_id;
	        $qask->pop_id = 2;
	        $qask->med_id = $qir->med_id;
	        $qask->med_type = $qir->med_type;
	        $qask->save();
	        
	        foreach ($ldqalt as $dqalt) {
	            $qtr = new QuestionTextResource();
	            $maxMedtxtId = DB::table('quagga_tekst')->max('med_id');
	            $qtr->med_id = $maxMedtxtId + 1;
	            $qtr->med_type = $dqalt->getQuestionText()->getMedType();
	            $qtr->tek_contents = $dqalt->getQuestionText()->getTekContents();
	            $qtr->save();
	            
	            $qalt = new QuestionAlternative();
	            $qalt->que_id = $que->que_id;
	            $qalt->alt_id = $dqalt->getAltId();
	            $qalt->med_id = $qtr->med_id; 
	            $qalt->med_type = $qtr->med_type;
	            $qalt->alt_correct = $dqalt->isCorrect() ? 1 : 0;
	            $qalt->save();
	        }
	        
	        $catids = [1];
	        if ($catids != null) {
	            $this->saveCategorizations($que, $catids);
	        }
	    });
	
	    return $que;
	}
	
	public function saveCategorizations($que, $catids) {
		$cgns = $que->categorizations;
		if (sizeof($cgns) == 1 && sizeof($catids) == 1) {
			// just an optimization to prevent needless deletes and inserts
			$cgn = $cgns->first();
			$cgn->category_id = array_values($catids)[0];
			$cgn->categorizable_id = $que->id;
			$cgn->categorizable_type = 'App\Models\Question';
			$cgn->exists = true;
			$que->categorizations()->save($cgn);
		} else  {
			$que->categorizations()->delete();
			foreach ($catids as $catid) {
				$cgn = new Categorization;
				$cgn->category_id = $catid;
				$cgn->categorizable_id = $que->id;
				$cgn->categorizable_type = 'App\Models\Question';
				$que->categorizations()->save($cgn);
			}
		}
	}
	
	// just a test
	public function countMetaValues() {
		$loa = $this->findQuestionArtifacts('3225');
		return sizeof($loa);
	}
}