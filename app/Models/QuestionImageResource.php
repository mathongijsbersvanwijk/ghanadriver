<?php

namespace App\Models;

use App\Support\Helpers\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class QuestionImageResource extends Model {
    use HasCompositePrimaryKey;
    
    protected $table = 'quagga_graphic';
    protected $primaryKey = array('med_id', 'med_type');
    protected $fillable = ['med_id', 'med_type', 'grf_code', 'grf_filename'];
    public $timestamps = false;
}
