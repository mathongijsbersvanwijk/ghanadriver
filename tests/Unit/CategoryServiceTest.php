<?php
namespace Tests\Unit;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class CategoryServiceTest extends TestCase {
	protected $cs;
	
	protected function setUp(): void {
	    parent::setUp();
	    $this->cs = new CategoryService;	
 	}
	
	public function  testFindByName() {
		$cat = $this->cs->findByName('lines-and-lanes');
		$this->assertNotNull($cat);
	}
		
	public function  testFindAllByName() {
		$cats = $this->cs->findAllByName(array('roundabouts'));
		$this->assertEquals(1, sizeof($cats));
		
		$cats = $this->cs->findAllByName(array('warning-signs', 'vertical-signalling'));
		foreach ($cats as $cat) {
			//echo $cat->name.PHP_EOL;
		}
		$this->assertEquals(2, sizeof($cats));
	}
	
	public function testFindNotFound() {
	    $this->expectException(ModelNotFoundException::class);
	    $this->expectExceptionMessage('No query results for model [App\Models\Category] 9999');
	    
	    $cat = $this->cs->find(9999);
	}
}
