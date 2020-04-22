<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['transaction_id','momo_transaction_id','financial_transaction_id','status','reason',
        'amount','currency','payer_message','payee_note'
    ];

    public function dvlaApplication() {
        return $this->belongsTo(DvlaApplication::class);
    }
}
