<?php
namespace Tests\Unit;

use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Tests\TestCase;

class QuestionServiceTest extends TestCase {
	protected $qs;
	
	protected function setUp(): void {
		parent::setUp();
		$this->qs = new QuestionService();
	}
	
	public function  testFindByName() {
		$loa = $this->qs->findQuestionArtifacts(3225);
		$this->assertEquals(6, sizeof($loa));
	}
	
	public function  testFindByMore() {
		$loa = $this->qs->findQuestionMetaData(3225);
		$this->assertEquals(1, sizeof($loa));
	}
	
 	public function testGetDisplayQuestion() {
 		$dq = QuestionToolkit::getDisplayQuestionById(3225, $this->qs);
 		$dqask = $dq->getDisplayQuestionAsked();
 		$this->assertEquals('You are held up in the middle of a level crossing and cannot restart the engine. The warning bell starts to ring. You should', $dqask->getQuestionText()->getTekContents());
	}
	
	public function testGetDisplayQuestions() {
	    $ldq = QuestionToolkit::getDisplayQuestionsByUser(2, $this->qs);
	    $this->assertEquals(3, sizeof($ldq));
	    
	}
	
	public function testFindBySingleCategory() {
		$ques = $this->qs->findBySingleCategory(1);
		$this->assertEquals(44, sizeof($ques));
		$ques = $this->qs->findBySingleCategory(12);
		$this->assertEquals(28, sizeof($ques));
	}
	
	public function testSaveQuestion() {
	    
	    
        $this->assertTrue(true);
    }
}
