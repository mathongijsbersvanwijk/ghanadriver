<?php
namespace Tests\Unit;

use App\Business\UserTest;
use App\Services\ProfileCategoryService;
use App\Services\QuestionService;
use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use App\Services\UserTestResultService;
use Tests\TestCase;

class UserTstTest extends TestCase {
	protected $tcfs;
	protected $pcs;
	protected $qs;
	protected $tqs;
	protected $utrs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->tcfs = new TestConfigurationService();
		$this->pcs = new ProfileCategoryService();
		$this->qs = new QuestionService();
		$this->tqs = new TestQuestionService();
		$this->utrs = new UserTestResultService();
	}
	
	public function testCreatePredefined() {
		$ut = new UserTest(1);
		// predefined test
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		$this->assertNotNull($ut);
	}
	
	public function testNavigationShallow() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(0);
		$this->assertEquals(1, $ut->getCurrentTquid());
		$this->assertEquals(3218, $tqu->getQuestion()->getQueId());
		$where = $ut->whereInTest();
		$this->assertEquals(1, $where);
		
		$ut->getNextQuestion(1);
		$this->assertEquals(2, $ut->getCurrentTquid());
		$tqu = $ut->getNextQuestion(2);
		$this->assertEquals(3, $ut->getCurrentTquid());
		$this->assertEquals(3111, $tqu->getQuestion()->getQueId());
		$where = $ut->whereInTest();
		$this->assertEquals(0, $where);
		
		$ut->getPreviousQuestion(3);
		$this->assertEquals(2, $ut->getCurrentTquid());
		$where = $ut->whereInTest();
		$this->assertEquals(0, $where);
		
		$tqu = $ut->getNextQuestion(9);
		$this->assertEquals(10, $ut->getCurrentTquid());
		$this->assertEquals(3230, $tqu->getQuestion()->getQueId());
		$where = $ut->whereInTest();
		$this->assertEquals(2, $where);
		
		$ut->getCurrentQuestion();
		$this->assertEquals(10, $ut->getCurrentTquid());
		$where = $ut->whereInTest();
		$this->assertEquals(2, $where);
		
		$ut->getThisQuestion(7);
		$this->assertEquals(7, $ut->getCurrentTquid());
		$where = $ut->whereInTest();
		$this->assertEquals(0, $where);
	}
		
	public function testNavigationDeep() {
	    $ut = new UserTest(1);
	    $ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
	    
	    $tqu = $ut->getNextQuestion(0);
	    $dq = $tqu->loadQuestion($this->qs);
	    $this->assertEquals(3218, $dq->getQueId());
	    $cattitle = $dq->getCategoryTitle();
	    $this->assertEquals("road-junctions", $cattitle);
	}
	
	public function testNavigationDeepUgc() {
	    $ut = new UserTest(1);
	    $ut->createTest(102, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
	    
	    $tqu = $ut->getNextQuestion(0);
	    $dq = $tqu->loadQuestion($this->qs);
	    $this->assertEquals(11004, $dq->getQueId());
	    $cattitle = $dq->getCategoryTitle();
	    $this->assertEquals("user-generated", $cattitle);
	}
	
	public function testAnswerQuestionCorrectly() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);

		$tqu = $ut->getNextQuestion(3);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3225, $dq->getQueId());
		
		$utq = $ut->answerQuestion(4, 4);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertEquals('Push the vehicle to clear the crossing', $dqalt->getQuestionText()->getTekContents());
		$this->assertTrue($dqalt->isCorrect());
		
		$this->assertEquals(0, $utq->isAlternativeCorrect(1));
		$this->assertEquals(0, $utq->isAlternativeCorrect(2));
		$this->assertEquals(0, $utq->isAlternativeCorrect(3));
		$this->assertEquals(1, $utq->isAlternativeCorrect(4));
	}
	
	public function testAnswerQuestionWrongly() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(4);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3429, $dq->getQueId());
		$this->assertEquals(1057, $dq->getDisplayQuestionAsked()->getQuestionImage()->getMedId());
		$this->assertEquals('B', $dq->getDisplayQuestionAsked()->getQuestionImage()->getMedType());
		
		$utq = $ut->answerQuestion(5, 1);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertEquals('The husband', $dqalt->getQuestionText()->getTekContents());
		$this->assertTrue(!$dqalt->isCorrect());
	}
	
	public function testAnswerQuestionNull() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(1);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(4179, $dq->getQueId());
		$utq = $ut->getCurrentQuestion();
		$dqalt = $utq->getQuestionAnswer();
		$this->assertNull($dqalt);
	}
	
	public function testCountAnswers() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(3);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3225, $dq->getQueId());
		$utq = $ut->answerQuestion(4, 4);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue($dqalt->isCorrect());
		
		$tqu = $ut->getNextQuestion(4);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3429, $dq->getQueId());
		$utq = $ut->answerQuestion(5, 2);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue($dqalt->isCorrect());
		
		$tqu = $ut->getNextQuestion(8);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(5123, $dq->getQueId());
		$utq = $ut->answerQuestion(9, 2);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertEquals('NO_OVERTAKING.jpg', $dqalt->getQuestionImage()->getGrfFileName());
		$this->assertTrue($dqalt->isCorrect());
		
		$ut->countAnwers();
		$counta = $ut->getCountAnswers();
		$this->assertEquals(3, $counta[0]);
		$this->assertEquals(0, $counta[1]);
		$this->assertEquals(7, $counta[2]);
	}
		
	public function testStop() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(3);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3225, $dq->getQueId());
		$ut->answerQuestion(4, 4);

		$ut->stopTest($this->utrs);
		$counta = $ut->getCountAnswers();
		$this->assertEquals(1, $counta[0]);
		
		$tqu = $ut->getNextQuestion(8);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(5123, $dq->getQueId());
		$ut->answerQuestion(9, 2);
	
		$ut->stopTest($this->utrs);
		$counta = $ut->getCountAnswers();
		$this->assertEquals(2, $counta[0]);
	}

	public function testFaultsOnly() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(2);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3111, $dq->getQueId());
		$utq = $ut->answerQuestion(3, 3);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue($dqalt->isCorrect());
		
		$tqu = $ut->getNextQuestion(3);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3225, $dq->getQueId());
		$utq = $ut->answerQuestion(4, 4);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue($dqalt->isCorrect());
		
		$tqu = $ut->getNextQuestion(4);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3429, $dq->getQueId());
		$utq = $ut->answerQuestion(5, 1);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue(!$dqalt->isCorrect());
		
		$ut->setFaultsOnly(true);
		
		$tqu = $ut->getNextQuestion(2);
		$this->assertEquals(5, $ut->getCurrentTquid());
		$tqu = $ut->getNextQuestion(5);
		$this->assertEquals(6, $ut->getCurrentTquid());
	}

	public function testGetCategoriesFaultAnswers() {
		$ut = new UserTest(1);
		$ut->createTest(2, 1, 1, $this->tcfs, $this->pcs, $this->qs, $this->tqs);
		
		$tqu = $ut->getNextQuestion(4);
		$dq = $tqu->loadQuestion($this->qs);
		$this->assertEquals(3429, $dq->getQueId());
		$utq = $ut->answerQuestion(5, 1);
		$dqalt = $utq->getQuestionAnswer();
		$this->assertTrue(!$dqalt->isCorrect());
	
		$catids = $ut->getCategoriesFaultAnswers();
		$this->assertEquals(2, $catids->get(0)); // defensive-driving
		$this->assertTrue($catids->contains(2));
	}
		
}
