<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahunajarans', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->string('semester');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->smallInteger('status')->nullable(true);
            $table->smallInteger('pendaftaran')->nullable(true);
            $table->smallInteger('krs')->nullable(true);
            $table->smallInteger('penilaian')->nullable(true);
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
        Schema::dropIfExists('tahunajarans');
    }
}
