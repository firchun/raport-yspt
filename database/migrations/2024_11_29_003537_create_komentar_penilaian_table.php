<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_santri')->constrained('santri')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori_penilaian')->onDelete('cascade');
            $table->foreignId('id_tahun_ajaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->text('komentar');
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
        Schema::dropIfExists('komentar_penilaian');
    }
};