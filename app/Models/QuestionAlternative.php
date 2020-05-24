<?php 
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class QuestionAlternative extends Model {
    use HasCompositePrimaryKey;
    
    protected $table = 'quagga_alternative';
    protected $primaryKey = array('que_id', 'alt_id');
    protected $fillable = ['que_id', 'alt_id', 'med_id', 'med_type', 'alt_correct'];
}
