<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supervisor_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
    
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down() {
        Schema::dropIfExists('assignments');
    }
};
