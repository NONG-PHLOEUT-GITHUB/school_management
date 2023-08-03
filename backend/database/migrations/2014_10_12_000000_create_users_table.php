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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 500)->nullable();
            $table->string('last_name', 500)->nullable();
            $table->string('gender', 200)->nullable();
            $table->string('age')->nullable();
            $table->integer('role')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 24)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('profile')->default('defult_profile.JPG');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            // $table->unsignedBigInteger('class_room_id')->nullable();
            // $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
