<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//         Schema::table('quagga_test', function ($table) {
//             $table->dropColumn('companyId');
//             $table->id()->first();
//             $table->foreignId('user_id')->default(2)->constrained(); // User 2 should always be the admin
//             $table->timestamps();
//         });
           
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
