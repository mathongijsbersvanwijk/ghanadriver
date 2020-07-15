<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuestionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('quagga_question', function ($table) {
            $table->enum('status', ['UPLOADED', 'APPROVED', 'REJECTED'])->after('que_id')->default('APPROVED');
            $table->string('reason')->after('status')->nullable();
            $table->dropColumn('que_help_url');
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
