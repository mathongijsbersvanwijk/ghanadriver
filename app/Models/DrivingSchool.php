<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrivingSchool extends Model {
	
    protected $table = 'quagga_drivingschool';
    protected $primaryKey = 'dvs_id';
    protected $fillable = ['dvs_id', 'dvs_name', 'dvs_latitude', 'dvs_longitude', 'dvs_description'];
}
