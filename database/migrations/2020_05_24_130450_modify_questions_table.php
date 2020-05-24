<?php
use Illuminate\Database\Migrations\Migration;

class ModifyQuestionsTable extends Migration
{

    /**
     * This was a one-off migration, see gdnew.sql
     *
     * @return void
     */
    public function up() {
//         Schema::table('quagga_question', function ($table) {
//             $table->id()->first();
//             $table->foreignId('user_id')->constrained(); // User 1 should always be the admin
//         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
//         Schema::table('quagga_question', function ($table) {
//             $table->dropColumn('user_id');
//             $table->dropColumn('id');
//         });
    }
}
