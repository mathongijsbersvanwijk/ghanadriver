<?php
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model {
	use HasCompositePrimaryKey;
	
	protected $table = 'quagga_test_document';
	protected $primaryKey = array('tst_id', 'tdo_id');
	protected $fillable = ['seq_id', 'que_id'];
}
