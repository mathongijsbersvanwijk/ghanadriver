<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('quagga_test_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('quagga_test');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('quagga_question');
            $table->integer('seq_id')->nullable();
            $table->integer('tqu_count_alt')->nullable();
        });
    }
      
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
