<?php
namespace App\Support\Helpers;

use App\Business\DisplayQuestion;
use App\Business\DisplayQuestionAlternative;
use App\Business\QuestionImage;
use App\Business\QuestionText;
use App\Services\QuestionService;
use Illuminate\Support\Collection;

class QuestionToolkit {
	// only used in unittests
    public static function getDisplayQuestionById($queId, QuestionService $qs) {
        $loa = $qs->findQuestionArtifacts($queId);
        if ($loa != null && sizeof($loa) > 0) {
            return QuestionToolkit::createDisplayQuestion($loa, null, $qs);
        }
        return null;
    }
    
    public static function getDisplayQuestionsByUser($userId, QuestionService $qs) {
        $loa = $qs->findQuestionAskedArtifactsByUser($userId);
        
        return QuestionToolkit::getDisplayQuestions($loa, $qs);
    }
    
    public static function getDisplayQuestionsByStatus($status, QuestionService $qs) {
        $loa = $qs->findQuestionAskedArtifactsByStatus($status);
        
        return QuestionToolkit::getDisplayQuestions($loa, $qs);
    }
    
    private static function getDisplayQuestions($loa, QuestionService $qs) {
        $ldq = new Collection();
        if ($loa != null && sizeof($loa) > 0) {
            $i = 0;
            while ($i < sizeof($loa)) {
                $medId = $loa[$i]->med_id;
                $medType = $loa[$i]->med_type;
                $tek = $loa[$i]->tek_contents;
                $grfFn = $loa[$i]->grf_filename;
                
                if ($medType == 'T') {
                    $dq = new DisplayQuestion($loa[$i]->que_id);
                    $dq->setId($loa[$i]->id);
                    $dq->setStatus($loa[$i]->status);
                    $ldq->push($dq);
                }
                
                QuestionToolkit::fillQuestionAsked($dq, $medId, $medType, $tek, $grfFn);
                $i++;
            }
        }
        
        return $ldq;
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
	
	private static function fillQuestionAsked($dq, $medId, $medType, $tek, $grfFn) {
	    $dqask = $dq->getDisplayQuestionAsked();
	    if ($medType == 'T') {
	        $dqask->setQuestionText(QuestionToolkit::createText($medId, $medType, $tek));
	    }
	    if ($medType == 'B') {
	        $dqask->setQuestionImage(QuestionToolkit::createImage($medId, $medType, $grfFn));
	    }

	    return $dq;
	}
	    
	public static function createText($medId, $medType, $tek) {
		$qt = new QuestionText();
		$qt->setMedid($medId); 
		$qt->setMedType($medType); 
		$qt->setTekContents($tek); 
		
		return $qt;
	}
	
	public static function createImage($medId, $medType, $grfFn) {
		$qi = new QuestionImage(); 
		$qi->setMedid($medId); 
		$qi->setMedType($medType); 
		$qi->setGrfFileName ($grfFn); 
		
		return $qi;
	}
}	




