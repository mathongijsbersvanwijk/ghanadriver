<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\ArticleService;
use App\Services\CategoryService;
use Illuminate\Console\Command;

class AddArticles extends Command {
	protected $signature = 'add:articles';
	protected $description = 'Save articles to database';
	
	private $as;
	private $cs;
	
	public function __construct() {
		parent::__construct();
		$this->as = new ArticleService();
		$this->cs = new CategoryService();
	}
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
    	$untypedArr = ['id' => '1','title' => 'General','uri' => 'SA.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '2','title' => 'Defensive driving','uri' => 'SB.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '3','title' => 'Emergency','uri' => 'SC.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '4','title' => 'Lines and lanes','uri' => 'SD.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '5','title' => 'Overtaking','uri' => 'SE.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '6','title' => 'Road junctions','uri' => 'SF.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '7','title' => 'Roundabouts','uri' => 'SG.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '8','title' => 'Reversing','uri' => 'SH.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '9','title' => 'Lights','uri' => 'SI.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '10','title' => 'Waiting and parking','uri' => 'SJ.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '11','title' => 'Warning signs','uri' => 'SW.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '12','title' => 'Prohibitory signs','uri' => 'SP.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '13','title' => 'Mandatory signs','uri' => 'SM.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '14','title' => 'Informatory signs','uri' => 'SX.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '15','title' => 'Vertical signalling','uri' => 'C1.html'];
    	$this->save($untypedArr);
    	$untypedArr = ['id' => '20','title' => 'Contents','uri' => 'Version2015.html'];
    	$this->save($untypedArr);
    }

    private function save($untypedArr) {
    	$art = new Article();
    	$art = $this->as->saveArticle($untypedArr, $art);

		// article title must be equal to category name
    	$cat = $this->cs->findByName($untypedArr['title']);
    	$catids = array();
    	$catids[0] = $cat->id;
    	$this->as->saveCategorizations($art, $catids);
    }
}
