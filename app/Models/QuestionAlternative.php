<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAlternative extends Model {
	
    protected $table = 'quagga_alternative';
    protected $primaryKey = array('que_id', 'alt_id');
    protected $fillable = ['que_id', 'alt_id', 'med_id', 'med_type', 'alt_correct'];
}
