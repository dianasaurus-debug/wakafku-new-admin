<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaqfReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waqf_returns', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(0);
            $table->string('account_number');
            $table->string('account_holder');
            $table->string('account_bank');
            $table->string('amount');
            $table->dateTime('returned_at');
            $table->integer('jangka')->default(1);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('waqf_id');
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
        Schema::dropIfExists('waqf_returns');
    }
}
