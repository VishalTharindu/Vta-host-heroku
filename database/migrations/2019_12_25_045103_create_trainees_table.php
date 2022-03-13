<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id')->unsigned();
            $table->unsignedBigInteger('batch_id')->unsigned();
            $table->string('image')->nullable();
            $table->string('enrollment_no')->nullable();
            $table->string('full_name');
            $table->string('name_with_initials');
            $table->enum('gender', ['male','female']);
            $table->string('ethnicity');
            $table->string('nic');
            $table->string('phone_number');
            $table->text('address');
            $table->string('city');
            $table->string('email')->nullable();
            $table->string('status')->default(0);
            $table->string('ojt_letter_issued')->default(0);
            $table->string('qualification');
            $table->string('forumA')->default(0);
            $table->string('forumB')->default(0);
            $table->date('ojt_start_date')->nullable();
            $table->date('ojt_end_date')->nullable();
            $table->unsignedBigInteger('training_institute_id')->unsigned()->nullable();
            $table->string('other_documents')->default('[]');
            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');

            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
                ->onDelete('cascade');

            $table->foreign('training_institute_id')
                ->references('id')
                ->on('training_institutes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainees');
    }
}