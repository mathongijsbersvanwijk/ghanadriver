<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Categorizable;
    
    protected $table = 'quagga_question';
    protected $primaryKey = 'que_id';
    protected $fillable = ['que_id', 'status', 'reason'];

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
