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
        Schema::create('pencapaian_quran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tahun_ajaran')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');
            $table->foreignId('id_santri')
                ->constrained('santri')
                ->onDelete('cascade');
            $table->enum('kelancaran', ['Jayyid Jiddan', 'Jayyid', 'Maqbul', 'Perlu Bimbingan']);
            $table->enum('makhraj', ['Jayyid Jiddan', 'Jayyid', 'Maqbul', 'Perlu Bimbingan']);
            $table->enum('tajwid', ['Jayyid Jiddan', 'Jayyid', 'Maqbul', 'Perlu Bimbingan']);
            $table->enum('kegigihan', ['Jayyid Jiddan', 'Jayyid', 'Maqbul', 'Perlu Bimbingan']);
            $table->enum('adab', ['Jayyid Jiddan', 'Jayyid', 'Maqbul', 'Perlu Bimbingan']);
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
        Schema::dropIfExists('pencapaian_quran');
    }
};