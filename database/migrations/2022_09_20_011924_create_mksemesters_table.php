<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMksemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mksemesters', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('tahunajarans_id');
            $table->smallInteger('kelas_id');
            $table->smallInteger('matakuliahs_id');
            $table->string('semester');
            $table->smallInteger('status');
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
        Schema::dropIfExists('mksemesters');
    }
}
