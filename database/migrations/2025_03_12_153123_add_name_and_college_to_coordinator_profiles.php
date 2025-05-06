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
        Schema::table('coordinator_profiles', function (Blueprint $table) {
            $table->string('name')->after('user_id'); // Add name column
            $table->string('college')->after('department'); // Add college column
            $table->dropColumn('phone'); // Remove phone column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('coordinator_profiles', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('college');
            $table->string('phone')->nullable(); // Restore phone column if rolled back
        });
    }
};
