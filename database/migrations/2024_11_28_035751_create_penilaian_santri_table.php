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
        Schema::create('penilaian_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategori_penilaian')->onDelete('cascade');
            $table->foreignId('id_point')->constrained('point_penilaian')->onDelete('cascade');
            $table->foreignId('id_tahun_ajaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->enum('nilai', ['1', '2', '3'])->comment('1 = Belum Berdampak, 2 = berkembang, 3 = mandiri')->default('1');
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
        Schema::dropIfExists('penilaian_santri');
    }
};