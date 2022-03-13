<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trainee_id')->unsigned();
            // $table->unsignedBigInteger('marked_by')->unsigned();
            // $table->string('marked_by_type');
            $table->string('year');
            $table->string('month');
            // $table->string('type');
            
            $table->integer('day_1')->default(-1);
            $table->integer('day_2')->default(-1);
            $table->integer('day_3')->default(-1);
            $table->integer('day_4')->default(-1);
            $table->integer('day_5')->default(-1);
            $table->integer('day_6')->default(-1);
            $table->integer('day_7')->default(-1);
            $table->integer('day_8')->default(-1);
            $table->integer('day_9')->default(-1);
            $table->integer('day_10')->default(-1);
            $table->integer('day_11')->default(-1);
            $table->integer('day_12')->default(-1);
            $table->integer('day_13')->default(-1);
            $table->integer('day_14')->default(-1);
            $table->integer('day_15')->default(-1);
            $table->integer('day_16')->default(-1);
            $table->integer('day_17')->default(-1);
            $table->integer('day_18')->default(-1);
            $table->integer('day_19')->default(-1);
            $table->integer('day_20')->default(-1);
            $table->integer('day_21')->default(-1);
            $table->integer('day_22')->default(-1);
            $table->integer('day_23')->default(-1);
            $table->integer('day_24')->default(-1);
            $table->integer('day_25')->default(-1);
            $table->integer('day_26')->default(-1);
            $table->integer('day_27')->default(-1);
            $table->integer('day_28')->default(-1);
            $table->integer('day_29')->default(-1);
            $table->integer('day_30')->default(-1);
            $table->integer('day_31')->default(-1);

            $table->timestamps();

            $table->foreign('trainee_id')
                ->references('id')
                ->on('trainees')
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
        Schema::dropIfExists('attendances');
    }
}
