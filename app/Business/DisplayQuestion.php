<?php
namespace App\Business;

use App\Models\Question;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;

class DisplayQuestion {
    private $id;
    private $queId;
    private $que;
	private $dqask;
	private $ldqalt;
	private $cattitle;
	private $status;
	private $reason;
	
    public function __construct($queId) {
		$this->queId = $queId;
		$this->que = new Question();
		$this->dqask = new DisplayQuestionAsked();
		$this->ldqalt = new Collection();
	}
	
	public function getId() {
	    return $this->id;
	}
	
	public function setId($id) {
	    $this->id = $id;
	}
	
	public function getQueId() {
		return $this->queId;
	}
	
	public function getQue() {
		return $this->que;
	}
	
	public function setQue($que) {
		$this->que = $que;
	}
	
	public function getDisplayQuestionAsked() {
		return $this->dqask;
	}
		
	public function setDisplayQuestionAsked($displayQuestionAsked) {
		$this->dqask = $displayQuestionAsked;
	}
	
	public function getListDisplayQuestionAlternative() {
		return $this->ldqalt;
	}
		
	public function setListDisplayQuestionAlternative($listDisplayQuestionAlternative) {
		$this->ldqalt = $listDisplayQuestionAlternative;
	}
		
	public function getDisplayQuestionAlternative($altId) {
		return $this->ldqalt->get($altId - 1);
	}
	
	public function getCategoryTitle() {
		return $this->cattitle;
	}
	
	public function setCategoryTitle() {
		$this->cattitle = $this->getCategorizations()->get(0)->category->name;
	}
		
	public function getCategorizations() {
		return $this->que->categorizations()->get();
	}

	public function getStatus() {
	    return $this->status;
	}
	
	public function setStatus($status) {
	    $this->status = $status;
	}
	
	public function getReason() {
	    return $this->reason;
	}
	
	public function setReason($reason) {
	    $this->reason = $reason;
	}
	
/* 	public static function getArticleByCategory($catId) {
		$as = App::make('articleservice');
 		$arts = $as->findBySingleCategory($catId);

 		return $arts->get(0);
	} 
 */
}	





