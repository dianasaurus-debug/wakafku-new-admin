<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->enum('jenis_lembaga', ['pribadi', 'organisasi']);
            $table->string('tahun_berdiri');
            $table->string('website')->nullable();
            $table->string('profil_organisasi')->nullable();
            $table->string('alamat_detail')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            //
        });
    }
}
