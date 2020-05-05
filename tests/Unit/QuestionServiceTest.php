<?php
namespace Tests\Unit;

use App\Services\QuestionService;
use App\Support\Helpers\QuestionToolkit;
use Tests\TestCase;

class QuestionServiceTest extends TestCase {
	protected $qs;
	
	public function setUp() {
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
	
	public function testFindBySingleCategory() {
		$ques = $this->qs->findBySingleCategory(1);
		$this->assertEquals(35, sizeof($ques));
		$ques = $this->qs->findBySingleCategory(12);
		$this->assertEquals(28, sizeof($ques));
	}
	
	public function testBasicTest() {
        $this->assertTrue(true);
    }
}
