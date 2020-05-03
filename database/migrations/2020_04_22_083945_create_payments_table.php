<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dvla_application_id')->constrained();
            
            $table->string('momo_transaction_id')->nullable();
            $table->string('financial_transaction_id')->nullable();
            
            $table->enum('status', ['PENDING', 'FAILED', 'SUCCESSFUL']);
            $table->string('reason')->nullable();
            $table->double('amount', 8, 2);
            $table->string('currency')->default('EUR');
            $table->string('payer_message')->nullable();
            $table->string('payee_note')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
