<?php
namespace App\Support\Helpers;

use App\Business\DisplayQuestion;
use App\Business\DisplayQuestionAlternative;
use App\Business\QuestionImage;
use App\Business\QuestionText;
use App\Services\QuestionService;

class QuestionToolkit {
	// NOT USED
	public static function getDisplayQuestionById($queId, QuestionService $qs) {
		$loa = $qs->findQuestionArtifacts($queId);
		if ($loa != null && sizeof($loa) > 0) {
			return QuestionToolkit::createDisplayQuestion($loa, null, $qs);
		}
		return null;
	}

	public static function getDisplayQuestion($dq, QuestionService $qs) {
		$loa = $qs->findQuestionArtifacts($dq->getQueId());
		if ($loa != null && sizeof($loa) > 0) {
			return QuestionToolkit::createDisplayQuestion($loa, $dq, $qs);
		}
		return null;
	}

	private static function createDisplayQuestion($loa, $dq, QuestionService $qs) {
		if ($dq == null) {
			$queId = $loa[0]->que_id;
			$dq = new DisplayQuestion($queId);
		}
		
		$que = $qs->findByQueId($loa[0]->que_id);
		$dq->setQue($que);
		
		$dqask = $dq->getDisplayQuestionAsked(); 
		$ldqalt = $dq->getListDisplayQuestionAlternative();
		
		for ($i = 0; $i < sizeof($loa); $i++) {
			$type = $loa[$i]->type; 
			$seq = $loa[$i]->seq; 
			$medId = $loa[$i]->med_id; 
			$medType = $loa[$i]->med_type; 
			$altCorrect = $loa[$i]->alt_correct; 
			$tek = $loa[$i]->tek_contents; 
			$grfFn = $loa[$i]->grf_filename; 
			
			if ($type == 'P') {
				if ($medType == 'T') {
					$dqask->setQuestionText(QuestionToolkit::createText($medId, $medType, $tek));
				}
				if ($medType == 'B') {
					$dqask->setQuestionImage(QuestionToolkit::createImage($medId, $medType, $grfFn));
				}
			}
			
			if ($type == 'A') {
				$dqalt = new DisplayQuestionAlternative($seq, $altCorrect); 
				$ldqalt->push($dqalt); 
				
				if ($medType == 'T') {
					$dqalt->setQuestionText(QuestionToolkit::createText($medId, $medType, $tek));
				}
				if ($medType == 'B') {
					$dqalt->setQuestionImage(QuestionToolkit::createImage($medId, $medType, $grfFn));
				}
			}
		}
		
		return $dq;
	}
	
	private static function createText ($medid, $medType, $tek) {
		$qt = new QuestionText();
		$qt->setMedid($medid); 
		$qt->setMedType($medType); 
		$qt->setTekContents($tek); 
		
		return $qt;
	}
	
	private static function createImage ($medid, $medType, $grfFn) {
		$qi = new QuestionImage(); 
		$qi->setMedid($medid); 
		$qi->setMedType($medType); 
		$qi->setGrfFileName ($grfFn); 
		
		return $qi;
	}
}	




