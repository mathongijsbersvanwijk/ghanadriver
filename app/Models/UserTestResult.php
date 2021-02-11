<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestResult extends Model {
	
	public $timestamps = false;
	
	protected $table = 'quagga_examination';
    protected $primaryKey = 'exa_id';
    protected $fillable = ['exa_id', 'prs_id', 'tst_id', 'exa_date_taken', 'pro_id', 'exa_count_tqu_correct', 'exa_mode'];
}
