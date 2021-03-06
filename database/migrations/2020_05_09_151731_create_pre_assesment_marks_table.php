<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreAssesmentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_assesment_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trainee_id')->unsigned();
            $table->unsignedBigInteger('subject_id')->unsigned();
            $table->string('preasses_marks')->nullable();

            $table->foreign('trainee_id')
                ->references('id')
                ->on('trainees')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('cascade');
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
        Schema::dropIfExists('pre_assesment_marks');
    }
}
