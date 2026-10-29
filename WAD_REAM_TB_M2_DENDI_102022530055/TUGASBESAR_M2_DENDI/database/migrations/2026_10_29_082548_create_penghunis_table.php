<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penghunis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_ktp');
            $table->string('pekerjaan');
            $table->string('no_hp');
            $table->string('kontak_darurat');
            $table->string('hubungan_kontak_darurat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penghunis');
    }
};