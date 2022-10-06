<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fakultas_id');
            $table->smallInteger('prodis_id');
            $table->smallInteger('dosen_pengampuh')->nullable(true);
            $table->string('semester', 20)->nullable(true);
            $table->string('kode_mk', 10);
            $table->string('nama_mk');
            $table->smallInteger('mk_kompetensi')->nullable(true);
            $table->smallInteger('bobot_kuliah')->nullable(true);
            $table->smallInteger('bobot_seminar')->nullable(true);
            $table->smallInteger('bobot_praktikum')->nullable(true);
            $table->smallInteger('konveksi_kredit_kejam')->nullable(true);
            $table->smallInteger('sikap')->nullable(true);
            $table->smallInteger('pengetahuan')->nullable(true);
            $table->smallInteger('keterampilan_umum')->nullable(true);
            $table->smallInteger('keterampilan_khusus')->nullable(true);
            $table->string('dokumen_rencana_pembelajaran', 50)->nullable(true);
            $table->string('unit_penyelenggara', 50);
            $table->smallInteger('tahun')->nullable(true);
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
        Schema::dropIfExists('matakuliahs');
    }
}
