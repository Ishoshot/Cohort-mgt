<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('student_one');
                $table->string('student_two');
                $table->string('student_one_fname');
                $table->string('student_two_fname');
                $table->string('cohort_id');
                $table->string('cohort_name');
                $table->string('topic_id');
                $table->string('topic_title');

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
        Schema::dropIfExists('pairs');
    }
}
