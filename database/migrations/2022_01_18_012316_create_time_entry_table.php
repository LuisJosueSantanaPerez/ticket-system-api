<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('time_entry', function (Blueprint $table) {
            $table->id()->unique()->index();
            $table->foreignId('employee_id')->constrained('employees');
            $table->timestamp('date_from')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_to')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('time_entry');
    }
}
