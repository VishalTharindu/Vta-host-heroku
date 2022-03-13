<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreAssesmentRsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_assesment_rsults', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trainee_id');
            $table->string('course_id');
            $table->string('batch_id');
            $table->string('attempt')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('pre_assesment_rsults');
    }
}
