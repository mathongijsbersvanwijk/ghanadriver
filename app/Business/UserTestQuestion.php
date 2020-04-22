<?php
namespace App\Business;

use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use App\Support\Helpers\WebConstants;
use Illuminate\Support\Facades\Cache;

class UserTestQuestion {
	private $dq;
	private $dqaAnswer;
	private $displayQuestionLoaded;
	private $answerResourceType;

    public function __construct($queId) {
		$this->dq = new DisplayQuestion($queId);
		$this->displayQuestionLoaded = false;
		$this->answerResourceType = 0;
    }

    public function loadQuestion(QuestionService $qs) {
    	if ($this->displayQuestionLoaded) {
    		$this->dq = Cache::get($this->dq->getQueId());
    	} else {
    		$this->dq = QuestionToolkit::getDisplayQuestion($this->dq, $qs);
    		$this->dq->setCategoryTitle();
    		$this->displayQuestionLoaded = true ; 
			Cache::put($this->dq->getQueId(), $this->dq, 7200);
			$this->answerResourceType = WebConstants::ANSWER_RESOURCE_TYPE_TEXT;
			$ldqalt = $this->dq->getListDisplayQuestionAlternative(); 
			foreach ($ldqalt as $dqalt) {
				$qii = $dqalt->getQuestionImage(); 
				if ($qii != null) {
					$this->answerResourceType = WebConstants::ANSWER_RESOURCE_TYPE_IMAGE;
				} else {
					break;
				}
			}
		}
		return $this->dq;
	}

	public function getAnswerResourceType() {
		return $this->answerResourceType;
	}

	public function getQuestion() {
		return $this->dq;
	}
	
	public function getQuestionAnswer() {
		return $this->dqaAnswer;
	}
	
	public function setQuestionAnswer($dqalt) {
		$this->dqaAnswer = $dqalt;
	}

	public function isAlternativeCorrect($altId) {
		$ldqa = $this->dq->getListDisplayQuestionAlternative(); 
		foreach ($ldqa as $dqa) {
			if ($dqa->isCorrect()){
				if ($altId == $dqa->getAltId()) {
					return 1;
				} else {
					return 0;
				}
			}
		}
		return 0;
	}
}	




