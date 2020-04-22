<?php

namespace App\Console\Commands;

use App\Services\QuestionService;
use Illuminate\Console\Command;

class PrintQuestion extends Command {
	protected $signature = 'print:question {queid}';
	
	private $qs;
	
	public function __construct() {
		parent::__construct();
		$this->qs = new QuestionService();
	}
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
    	$queId = $this->argument('queid');
    	$loa = $this->qs->findQuestionArtifacts($queId);
    	dd($loa);
    }
}
