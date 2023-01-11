<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPaymentReminder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_reminders', function (Blueprint $table) {
            $table->date('scheduled_date')->change();
            $table->string('amount');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_reminders', function (Blueprint $table) {
            //
        });
    }
}
