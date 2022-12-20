<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaqfTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waqf_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code')->unique();
            $table->text('message')->nullable();
            $table->string('amount')->default(0);
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_method');
            $table->integer('status')->default(0);
            $table->enum('jenis_wakaf', ['berjangka', 'abadi']);
            $table->string('atas_nama');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('waqif_id');
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
        Schema::dropIfExists('waqf_transactions');
    }
}
