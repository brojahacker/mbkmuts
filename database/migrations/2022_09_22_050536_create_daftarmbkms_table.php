<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarmbkmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftarmbkms', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('kategorimbkms_id');
            $table->smallInteger('programmbkms_id');
            $table->smallInteger('tahunajarans_id');
            $table->smallInteger('users_id');
            $table->string('nama')->nullable(true);
            $table->string('nim')->nullable(true);
            $table->string('prodi')->nullable(true);
            $table->string('fakultas')->nullable(true);
            $table->string('telepon', 20)->nullable(true);
            $table->text('alamat')->nullable(true);
            $table->string('ipk', 10);
            $table->text('file1');
            $table->text('file2');
            $table->date('tanggal')->nullable(true);
            $table->smallInteger('status');
            $table->text('keterangan')->nullable(true);
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
        Schema::dropIfExists('daftarmbkms');
    }
}
