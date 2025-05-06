<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the users table
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('student_number')->nullable();
            $table->string('college')->nullable();
            $table->string('department')->nullable();
            $table->string('profile_picture')-> // Store the file path
            $table->timestamps();
            $table->boolean('is_completed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
