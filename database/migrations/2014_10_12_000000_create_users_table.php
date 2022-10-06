<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('counter');
            $table->string('name');
            $table->string('prodi');
            $table->string('fakultas');
            $table->string('nik');
            $table->string('nidn');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('kelamin');
            $table->string('agama');
            $table->string('jabatan');
            $table->string('pendidikan');
            $table->string('image');
            $table->string('paraf');
            $table->smallInteger('role_id');
            $table->smallInteger('is_active');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
