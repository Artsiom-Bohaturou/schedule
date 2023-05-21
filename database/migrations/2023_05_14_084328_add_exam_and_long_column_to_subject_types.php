<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamAndLongColumnToSubjectTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_types', function (Blueprint $table) {
            $table->boolean('exam')->default(false);
            $table->boolean('long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_types', function (Blueprint $table) {
            $table->removeColumn('exam');
            $table->removeColumn('long');
        });
    }
}
