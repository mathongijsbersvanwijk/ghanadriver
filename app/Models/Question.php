<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Categorizable;
    protected $table = 'quagga_question';
    protected $fillable = ['que_id'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
