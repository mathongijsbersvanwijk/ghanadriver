<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DvlaApplication extends Model
{
    protected $fillable = ['name','license_class','dvla_center','service_type','payment_option','comments'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
