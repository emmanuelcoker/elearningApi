<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_curricula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->integer('curriculum_number')->default(1);
            $table->string('curriculum_title');
            $table->string('objectives');
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
        Schema::dropIfExists('course_curricula');
    }
};
