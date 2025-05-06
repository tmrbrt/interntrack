<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('user_id');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            //
        });
    }
};
