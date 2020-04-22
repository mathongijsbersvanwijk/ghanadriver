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
    		
    		$que = $this->qs->find($loa[0]->doc_id);
    		$catName = $this->getCategoryName($loa[0]->value);
    		$cat = $this->cs->findByName($catName);
    		$catids = array();
    		$catids[0] = $cat->id;
    		
    		$this->qs->saveCategorizations($que, $catids);
    	}
    }
    
    private function getCategoryName($value) {
    	if ($value == 'SA') {
    		return "General";
    	}
    	if ($value == 'SB') {
    		return "Defensive driving";
    	}
    	if ($value == 'SC') {
    		return "Emergency";
    	}
    	if ($value == 'SD') {
    		return "Lines and lanes";
    	}
    	if ($value == 'SE') {
    		return "Overtaking";
    	}
    	if ($value == 'SF') {
    		return "Road junctions";
    	}
    	if ($value == 'SG') {
    		return "Roundabouts";
    	}
    	if ($value == 'SH') {
    		return "Reversing";
    	}
    	if ($value == 'SI') {
    		return "Lights";
    	}
    	if ($value == 'SJ') {
    		return "Waiting and parking";
    	}
    	if ($value == 'SW') {
    		return "Warning signs";
    	}
    	if ($value == 'SP') {
    		return "Prohibitory signs";
    	}
    	if ($value == 'SM') {
    		return "Mandatory signs";
    	}
    	if ($value == 'SX') {
    		return "Informatory signs";
    	}
    	if ($value == 'C1') {
    		return "Vertical signalling";
    	}
    	echo 'ERROR value not found: '.$value;

    	return null;
    }
}
