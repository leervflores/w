<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusDriversTable extends Migration
{
    public function up()
    {
        Schema::create('bus_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('conductor_id')->unique();
            $table->string('password');
            $table->string('license_number');
            $table->string('document_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'changes_requested'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bus_drivers');
    }
}
