<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('punctuality');
            $table->unsignedInteger('professionalism');
            $table->unsignedInteger('innovation');
            $table->unsignedInteger('respect');
            $table->unsignedInteger('communication');
            $table->unsignedInteger('management');
            $table->unsignedInteger('leadership');
            $table->unsignedInteger('delivery');
            $table->unsignedInteger('inclusiveness');
            $table->unsignedInteger('appearance');
            $table->unsignedInteger('total')->nullable();
            $table->unsignedInteger('average')->nullable();
            $table->unsignedInteger('grade')->nullable();
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
        Schema::dropIfExists('entries');
    }
}
