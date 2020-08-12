<?php 
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

// NOT USED
class QuestionResource extends Model {
    use HasCompositePrimaryKey;
    
    protected $table = 'quagga_medium';
    protected $primaryKey = array('med_id', 'med_type');
    protected $fillable = ['med_id', 'med_type', 'med_name'];
    public $timestamps = false;
}
