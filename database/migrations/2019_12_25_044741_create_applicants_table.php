<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_id')->unsigned();
            $table->integer('selected_course_id')->default(0);
            $table->string('full_name');
            $table->string('name_with_initials');
            $table->enum('gender', ['male','female']);
            $table->string('ethnicity');
            $table->string('nic');
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->text('address');
            $table->string('city');
            $table->string('qualification');
            $table->string('status')->default(0);
            $table->text('rejected_reason')->nullable();
            $table->timestamps();

            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
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
        Schema::dropIfExists('applicants');
    }
}
