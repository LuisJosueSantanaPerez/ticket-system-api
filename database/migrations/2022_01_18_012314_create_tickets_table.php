<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('tickets', function (Blueprint $table) {
            $table->id()->unique()->index();
            $table->string('number', 6)->index();
            $table->timestamp('date')->index();
            $table->string('title', 50);
            $table->text('description');
            $table->foreignId('kind_id')->constrained('kinds');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('employee_id')->constrained('employees');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
