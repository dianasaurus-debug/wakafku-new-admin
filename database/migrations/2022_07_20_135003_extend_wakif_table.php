<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendWakifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waqifs', function (Blueprint $table) {
            $table->string('otp_code')->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->tinyInteger('is_verified')->nullable();
            $table->string('phone')->change()->nullable();
            $table->text('address')->change()->nullable();
            $table->integer('gender')->change()->comment('1 male, 0 female');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waqifs', function (Blueprint $table) {
            //
        });
    }
}
