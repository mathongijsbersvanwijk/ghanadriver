<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionResource extends Model {
	
    protected $table = 'quagga_medium';
    protected $primaryKey = array('med_id', 'med_type');
    protected $fillable = ['med_id', 'med_type', 'alt_correct'];
}
