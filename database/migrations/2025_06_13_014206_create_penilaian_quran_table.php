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
        Schema::create('penilaian_quran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_quran')
                ->constrained('kategori_penilaian_quran')
                ->onDelete('cascade');
            $table->foreignId('id_tahun_ajaran')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');
            $table->foreignId('id_santri')
                ->constrained('santri')
                ->onDelete('cascade');
            $table->string('komentar')->nullable();
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
        Schema::dropIfExists('penilaian_quran');
    }
};