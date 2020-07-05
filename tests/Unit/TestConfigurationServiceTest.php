<?php
namespace Tests\Unit;

use App\Services\TestConfigurationService;
use Tests\TestCase;

class TestConfigurationServiceTest extends TestCase {
	protected $tcfs;
	
	protected function setUp(): void {
	    parent::setUp();
		$this->tcfs = new TestConfigurationService;	
 	}
	
 	public function  testFindByTstId() {
	    $tcf = $this->tcfs->findByTstId(['tst_id' => 103]);
		$this->assertNotNull($tcf);
		echo $tcf->tst_description.PHP_EOL;
	}

	public function  testFindQuestions() {
	    $tcf = $this->tcfs->find(2);
	    $this->assertNotNull($tcf);
	    $this->assertEquals(10, sizeof($tcf->questions));
	    echo $tcf->tst_description.PHP_EOL;
	}
}
