<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('driver_verification_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('action');
            $table->text('remarks')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            // Foreign keys
            $table->foreign('driver_id')->references('id')->on('bus_drivers')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('driver_verification_logs');
    }
};

