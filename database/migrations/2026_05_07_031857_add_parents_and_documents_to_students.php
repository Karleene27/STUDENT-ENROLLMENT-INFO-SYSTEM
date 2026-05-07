<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('psa_file')->nullable();          // path to uploaded file
            $table->string('good_moral_file')->nullable();
            $table->string('form137_file')->nullable();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'mother_name', 'father_name', 'mother_occupation', 'father_occupation',
                'psa_file', 'good_moral_file', 'form137_file'
            ]);
        });
    }
};