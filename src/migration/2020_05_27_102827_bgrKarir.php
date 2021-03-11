<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BgrKarir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_karir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perusahaan_id')->index();
            $table->string('judul');
            $table->string('posisi');
            $table->json('tags')->nullable();
            $table->string('type_pekerjaan');
            $table->string('remote');
            $table->string('matauang');
            $table->json('kualifikasi')->nullable();
            $table->json('skill')->nullable();
            $table->json('tugas')->nullable();
            $table->double('gaji_max')->nullable();
            $table->double('gaji_min')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status',['Aktif','Tidak Aktif','Take Down'])->default('Aktif');
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
        Schema::dropIfExists('bgr_karir');
    }
}
