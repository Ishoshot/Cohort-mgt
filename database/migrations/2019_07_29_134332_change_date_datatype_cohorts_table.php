<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateDatatypeCohortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cohorts', function (Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cohorts', function (Blueprint $table) {
             $table->datetime('start_date')->change();
            $table->datetime('end_date')->change();
        });
    }
}
