<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
	use Categorizable;
	
	protected $table = 'quagga_question';
	protected $primaryKey = 'que_id';
}
