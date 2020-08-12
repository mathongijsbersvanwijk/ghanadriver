<?php
namespace Tests\Unit;

use App\Business\PredefinedTest;
use App\Services\TestConfigurationService;
use App\Services\TestQuestionService;
use Tests\TestCase;

class PredefinedTstTest extends TestCase {
	protected $tcfs;
	protected $tqs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->tcfs = new TestConfigurationService();
		$this->tqs = new TestQuestionService();
	}
	
	public function  testGenerate() {
		$pt = new PredefinedTest(2, $this->tcfs, $this->tqs);
		$this->assertNotNull($pt);
		$this->assertEquals(10, sizeof($pt->getQueIds()));
	
		
	}
}
