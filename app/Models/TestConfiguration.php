<?php 
namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class TestConfiguration extends Model {
	use HasCompositePrimaryKey;
	
    protected $table = 'quagga_test';
    protected $primaryKey = array('companyId', 'tst_id'); 
    protected $fillable = ['pro_id', 'tst_type', 'tst_description', 'tst_count_tqu', 'tst_count_min_success'];
}
