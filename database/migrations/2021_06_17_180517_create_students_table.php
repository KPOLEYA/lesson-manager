<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('firstname');
            $table->unsignedBigInteger('level_id');
            $table->string('class_option')->nullable();
            $table->string('email')->unique();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('parents_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('parents_id')->references('id')->on('parents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
