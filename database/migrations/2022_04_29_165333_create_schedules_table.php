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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_type_id')->constrained('subject_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->smallInteger('week_number');
            $table->foreignId('weekday_id')->constrained('weekdays')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('building');
            $table->integer('auditory');
            $table->integer('subgroup')->nullable();
            $table->foreignId('subject_time_id')->nullable()->constrained('subject_times')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('date')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
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
        Schema::dropIfExists('schedules');
    }
};
