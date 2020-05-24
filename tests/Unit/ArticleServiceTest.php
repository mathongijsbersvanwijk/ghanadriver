<?php
namespace Tests\Unit;

use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ArticleServiceTest extends TestCase {
  	public function test1() {
  		$a = App::make('articles');
  		$articles = $a->getAll();
  		$this->assertEquals(19, sizeof($articles));
 	}
 	
 	public function test2() {
 		$a = App::make('articles');
 		$articles = $a->getByTitle('roundabouts');
 		echo $articles->first()->title;
 		$this->assertEquals(1, sizeof($articles));
 	}
}
