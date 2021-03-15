<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BgrKarirPerusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_karir_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->uuid('foto')->nullable();
            $table->string('perusahaan')->nullable();
            $table->text('keterangan_singkat')->nullable();
            $table->string('email')->nullable();
            $table->string('notelp')->nullable();
            $table->string('nowa')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('alamat')->nullable();
            $table->string('web')->nullable();
            $table->string('fb')->nullable();
            $table->string('ig')->nullable();
            $table->string('linkedin')->nullable();
            $table->boolean('verifikasi')->default(0);
            $table->boolean('vendor')->default(0);
            $table->enum('status',['Aktif','Tidak Aktif'])->default('Aktif');
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
        Schema::dropIfExists('bgr_karir_perusahaan');
    }
}
