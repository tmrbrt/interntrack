<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('supervisor_id'); // Add file_path column
        });
    }

    public function down() {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('file_path'); // Remove column if migration is rolled back
        });
    }
};
