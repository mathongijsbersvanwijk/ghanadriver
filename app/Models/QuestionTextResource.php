<?php
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class QuestionTextResource extends Model {
    use HasCompositePrimaryKey;
    
    protected $table = 'quagga_tekst';
    protected $primaryKey = array('med_id', 'med_type');
    protected $fillable = ['med_id', 'med_type', 'tek_contents'];
    public $timestamps = false;
}
