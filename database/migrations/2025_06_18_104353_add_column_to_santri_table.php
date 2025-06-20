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
        Schema::table('santri', function (Blueprint $table) {
            $table->enum('status_sekolah', ['Dalam Pondok', 'Luar Pondok', 'Tidak Sekolah'])
                ->default('Dalam Pondok')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->enum('status_sekolah', ['Dalam Pondok', 'Luar Pondok', 'Tidak Sekolah'])
                ->default('Dalam Pondok')
                ->nullable();
        });
    }
};