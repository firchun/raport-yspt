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
            $table->string('code', 20)->nullable()->after('id');
        });

        $santris = \App\Models\Santri::whereNull('code')->get();

        foreach ($santris as $santri) {
            do {
                $code = 'SPT-' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
            } while (\App\Models\Santri::where('code', $code)->exists());

            $santri->code = $code;
            $santri->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('santri', function (Blueprint $table) {
            //
        });
    }
};
