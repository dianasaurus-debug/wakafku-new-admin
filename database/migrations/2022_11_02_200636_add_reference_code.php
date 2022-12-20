<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waqf_transactions', function (Blueprint $table) {
            $table->string('reference_code');
            $table->string('redirect_link')->nullable();
            $table->dropColumn('payment_method');
            $table->unsignedInteger('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waqf_transactions', function (Blueprint $table) {
            //
        });
    }
}
