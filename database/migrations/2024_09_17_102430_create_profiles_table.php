<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable(); 
            $table->string('location')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('school_name')->nullable();
            $table->string('universe_name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone_number')->nullable();
            $table->string('professional_title')->nullable();
            $table->text('skills')->nullable();
            $table->text('interests')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}