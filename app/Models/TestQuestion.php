<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model {
	public $timestamps = false;
	
	protected $table = 'quagga_test_question';
	protected $fillable = ['test_id', 'question_id', 'que_id', 'seq_id', 'tqu_count_alt'];

	public function askedInTest() {
	    return $this->belongsTo(TestConfiguration::class, 'test_id');
	}
	
	public function refersToQuestion() {
	    return $this->belongsTo(Question::class, 'question_id');
	}
}
