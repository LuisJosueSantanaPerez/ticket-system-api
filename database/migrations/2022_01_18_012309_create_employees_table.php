<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->unique()->index();
            $table->string('number', 11)->index();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 255)->unique()->index();
            $table->string('password', 255);
            $table->timestamp('email_verified_at');
            $table->boolean('activated')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
