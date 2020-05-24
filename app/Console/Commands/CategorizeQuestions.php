<?php
namespace App\Console\Commands;

use App\Services\CategoryService;
use App\Services\QuestionService;
use Illuminate\Console\Command;

class CategorizeQuestions extends Command {
    protected $signature = 'categorize:questions';
    protected $description = 'This does it';

    private $qs;
    private $cs;
    
    public function __construct() {
    	parent::__construct();
    	$this->qs = new QuestionService();
    	$this->cs = new CategoryService();
    }
    
    public function handle() {
    	$ques = $this->qs->findAll();
    	foreach ($ques as $que) {
    		$loa = $this->qs->findQuestionMetaData($que->que_id);
    		echo 'Categorizing '.$loa[0]->doc_id.' as '.$loa[0]->value.PHP_EOL;
    		
    		$que = $this->qs->findByQueId($loa[0]->doc_id);
    		$catName = $this->getCategoryName($loa[0]->value);
    		$cat = $this->cs->findByName($catName);
    		$catids = array();
    		$catids[0] = $cat->id;
    		
    		$this->qs->saveCategorizations($que, $catids);
    	}
    }
    
    private function getCategoryName($value) {
    	if ($value == 'SA') {
    		return "general";
    	}
    	if ($value == 'SB') {
    		return "defensive-driving";
    	}
    	if ($value == 'SC') {
    		return "emergency";
    	}
    	if ($value == 'SD') {
    		return "lines-and-lanes";
    	}
    	if ($value == 'SE') {
    		return "overtaking";
    	}
    	if ($value == 'SF') {
    		return "road-junctions";
    	}
    	if ($value == 'SG') {
    		return "roundabouts";
    	}
    	if ($value == 'SH') {
    		return "reversing";
    	}
    	if ($value == 'SI') {
    		return "lights";
    	}
    	if ($value == 'SJ') {
    		return "waiting-and-parking";
    	}
    	if ($value == 'SW') {
    		return "warning-signs";
    	}
    	if ($value == 'SP') {
    		return "prohibitory-signs";
    	}
    	if ($value == 'SM') {
    		return "mandatory-signs";
    	}
    	if ($value == 'SX') {
    		return "informatory-signs";
    	}
    	if ($value == 'C1') {
    		return "vertical-signalling";
    	}
    	echo 'ERROR value not found: '.$value;

    	return null;
    }
}
