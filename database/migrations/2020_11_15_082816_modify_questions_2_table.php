<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuestions2Table extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('quagga_test_question', function (Blueprint $table) {
            $table->dropForeign('quagga_test_question_question_id_foreign');
        });
        
            Schema::table('quagga_question', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->primary('que_id');
        });
                
                Schema::table('quagga_test_question', function (Blueprint $table) {
            $table->foreign('que_id')->references('que_id')->on('quagga_question');
        });
                
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
