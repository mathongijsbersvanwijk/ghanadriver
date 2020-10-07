<?php
namespace Tests\Unit;

use App\Models\TestQuestion;
use App\Services\TestConfigurationService;
use Tests\TestCase;

class TestConfigurationServiceTest extends TestCase {
	protected $tcfs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->tcfs = new TestConfigurationService;	
 	}
	
 	public function testFindByTstId() {
	    $tcf = $this->tcfs->find(3);
		$this->assertNotNull($tcf);
		echo $tcf->tst_description.PHP_EOL;
	}

	public function testFindQuestions() {
	    $tcf = $this->tcfs->find(2);
	    $this->assertNotNull($tcf);
	    $this->assertEquals(10, sizeof($tcf->questions));
	    $this->assertEquals(10, $tcf->questions()->count());
	    $ok = $tcf->questions->contains(function($value, $key) {
	        return $value->que_id == 3429;
	    });
	    $this->assertTrue($ok);
	}

	public function testFindTestsWithQuestion() {
	    $ltcf = $this->tcfs->findAllByQuestion(172);
	    $this->assertEquals(2, $ltcf->first()->id);
	}
	
// 	public function testFindApprovedQuestionsInTest() {
// 	    $ltqu = $this->tcfs->findApprovedQuestions(7);
// 	    $this->assertEquals(1001, $ltqu->first()->question_id);
// 	}
}
