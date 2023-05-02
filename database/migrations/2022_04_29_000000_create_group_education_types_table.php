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
        Schema::create('group_education_types', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviated_name')->nullable();
            $table->string('full_name'); // Высшее, среднее, ...
            $table->string('time_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_education_types');
    }
};
