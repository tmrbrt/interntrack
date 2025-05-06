<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false); // New column
        });
    }

    public function down()
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn('is_completed');
        });
    }
};
