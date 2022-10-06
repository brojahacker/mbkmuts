<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenmksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosenmks', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('users_id');
            $table->smallInteger('matakuliahs_id');
            $table->smallInteger('kelas_id');
            $table->smallInteger('tahunajarans_id');
            $table->smallInteger('semester');
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
        Schema::dropIfExists('dosenmks');
    }
}
