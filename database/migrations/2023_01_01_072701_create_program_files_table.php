<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_files', function (Blueprint $table) {
            $table->id();
            $table->string('surat_permohonan_wakaf')->nullable();
            $table->string('surat_pendaftaran_wakaf')->nullable();
            $table->string('ikrar_wakaf')->nullable();
            $table->string('proposal_program')->nullable();
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
        Schema::dropIfExists('program_files');
    }
}
