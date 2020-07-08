<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestConfiguration extends Model
{
    protected $table = 'quagga_test';
    protected $fillable = ['pro_id','tst_type','tst_description','tst_count_tqu','tst_count_min_success',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questions() {
        return $this->hasMany(TestQuestion::class, 'test_id');
    }
}
