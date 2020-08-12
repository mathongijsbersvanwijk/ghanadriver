<?php
namespace App\Business;

use Illuminate\Support\Collection;
use App\Services\ProfileCategoryService;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use App\Services\UserTestResultService;
use App\Exceptions\RedoFaultsNotPossibleException;
use App\Support\Helpers\WebConstants;

class UserTest {
	private $userId;
	private $test;
	private $currentTquId;
	private $whereInTest;
	private $mode;
	private $faultsOnly;
	private $lutq;
	private $utr;
	private $countAnswers;

    public function __construct($userId) {
    	$this->userId = $userId;
    	$this->faultsOnly = false;
    	$this->lutq = new Collection();
    }

    public function createTest($tstId, $op, $mode, TestConfigurationService $tcfs, ProfileCategoryService $pcs, QuestionService $qs, TestQuestionService $tqs) { 
    	if (($op == WebConstants::PREDEFINED_TEST)) {
    		$this->test = new PredefinedTest($tstId, $tcfs, $tqs);
		} else {
			$this->test = new ProfiledTest($tstId, $tcfs, $pcs, $qs);
		}
		$this->mode = $mode; 
		$queIds = $this->test->getQueIds(); 
		for ($i = 0; $i < count($queIds); $i++) {
			$this->lutq->push(new UserTestQuestion($queIds[$i]));
		}
	}

	public function stopTest(UserTestResultService $utrs) {
		$this->countAnwers();
		$this->utr = $utrs->saveUserTestResult($this->utr, $this->userId, $this->test->getTcf()->id, $this->test->getTcf()->pro_id, 
				$this->countAnswers[0], $this->mode);
	}

	public function getMode() {
		return $this->mode;
	}

	public function setMode($mode) {
		$this->mode = $mode;
	}

	public function setFaultsOnly($faultsOnly) {
		$this->faultsOnly = $faultsOnly;
	}

	public function whereInTest() {
		return $this->whereInTest;
	}

	public function getNextQuestion($tquId) {
		// test questions go from 1 to lutq.size()
		$i = ($tquId - 1);
		$i++;
		if ($this->faultsOnly) {
			for (; $i < sizeof($this->lutq); $i++) {
				if ($this->isFault($i))
					break;
			}
			if ($tquId == 0 && $i == sizeof($this->lutq)) {
				throw new RedoFaultsNotPossibleException();
			}
		}
		
		if ($i < sizeof($this->lutq)) {
			$this->currentTquId = ($i + 1);
		}
		return $this->getCurrentQuestion();
	}

	public function getPreviousQuestion($tquId) {
		// test questions go from 1 to lutq.size()
		$i = ($tquId - 1);
		$i--;
		if ($this->faultsOnly) {
			for (; $i > -1; $i--) {
				if ($this->isFault($i))
					break;
			}
			if ($tquId == 0 && $i == sizeof($this->lutq)) {
				throw new RedoFaultsNotPossibleException();
			}
		}
		
		if ($i > -1) {
			$this->currentTquId = ($i + 1);
		}
		return $this->getCurrentQuestion();
	}

	public function getThisQuestion($tquid) {
		$this->currentTquId = $tquid; 
		return $this->getCurrentQuestion();
	}

	public function getCurrentQuestion() {
		$this->whereInTest = $this->checkWhereInTest(); 
		return $this->getUserTestQuestion($this->currentTquId);
	}
	
	private function checkwhereInTest() {
		$where = 0; 

		$i = $this->currentTquId - 1; 
		$i--;
		if ($this->faultsOnly) {
			for (; $i > -1; $i--) {
				if ($this->isFault($i))
					break;
			}
		}
		if ($i == -1) 
			$where |= WebConstants::BEGIN_OF_TEST;
		
		$i = $this->currentTquId - 1;
		$i++;
		if ($this->faultsOnly) {
			for (; $i < sizeof($this->lutq); $i++) {
				if ($this->isFault($i))
					break;
			}
		}
		if ($i == sizeof($this->lutq))
			$where |= WebConstants::END_OF_TEST; 
		
		return $where;
	}

	private function isFault($i) {
		$utq = $this->lutq->get($i);
		$dqaAnswer = $utq->getQuestionAnswer();
		if ($dqaAnswer == null || !$dqaAnswer->isCorrect()) {
			return true;
		} else {
			return false;
		}
	}

	public function getCurrentTquid() {
		return $this->currentTquId;
	}

	public function answerQuestion($tquld, $altId) {
		$utq = $this->lutq->get($tquld - 1);
	 	$dq = $utq->getQuestion();
	 	$dqa = $dq->getDisplayQuestionAlternative($altId);
	 	$utq->setQuestionAnswer($dqa);
	 	return $utq;
	}

	public function flagQuestion($i) {
		return null;
	}
	
	public function getTest() {
		return $this->test;
	}
	
	public function getUserTestQuestions() {
		return $this->lutq;
	}

	public function getUserTestQuestion($tquid) {
		return $this->lutq->get($tquid - 1);
	}

	public function countAnwers() {
		if ($this->countAnswers == null) {
			$this->countAnswers = array();
		}
		$ia = array(0, 0, 0); 
		foreach ($this->lutq as $utq) {
			$dqa = $utq->getQuestionAnswer();
			if ($dqa != null) {
				if ($dqa->isCorrect()) {
					$ia[0]++;
				} else {
					$ia[1]++;
				}
			} else {
				$ia[2]++;
			}
		}
		for ($i = 0; $i < count($ia); $i++) {
			$this->countAnswers[$i] = $ia[$i];
		}
	}
	
	public function getCountAnswers() {
		return $this->countAnswers;
	}

	public function getCategoriesFaultAnswers() {
		$cats = new Collection();
		foreach ($this->lutq as $utq) {
			$dqa = $utq->getQuestionAnswer(); 
			if ($dqa != null && !$dqa->isCorrect()) {
				$dq = $utq->getQuestion();
				$cats->push($dq->getCategorizations()->get(0)->category->id);
			}
		}
		
		return $cats;
	}

	public function getCountTestQuestions() {
	    return $this->test->getTcf()->tst_count_tqu;
	}
	
	public function getCountMinSuccess() {
	    return $this->test->getTcf()->tst_count_min_success;
	}
}	

