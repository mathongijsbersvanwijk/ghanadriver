<?php 
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProfileCategory extends Model {
	use HasCompositePrimaryKey;
	
	protected $table = 'quagga_partition';
    protected $primaryKey = array('pro_id','cat_id');
    protected $fillable = ['par_perc', 'par_abs'];
}
