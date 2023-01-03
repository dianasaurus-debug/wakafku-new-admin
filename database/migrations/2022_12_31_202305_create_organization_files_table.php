<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_files', function (Blueprint $table) {
            $table->id();
            $table->string('akta_pendirian')->nullable();
            $table->string('company_profile')->nullable();
            $table->string('npwp')->nullable();
            $table->string('pengesahan_kemenkumham')->nullable();
            $table->string('rekomendasi_lkspwu')->nullable();
            $table->string('keterangan_dom')->nullable();
            $table->string('sertif_kompetensi')->nullable();
            $table->string('rencana_kerja')->nullable();
            $table->string('surat_permohonan')->nullable();
            $table->string('surat_pernyataan_diaudit')->nullable();
            $table->string('surat_wakaf_bulanan')->nullable();
            $table->string('surat_pelaksanaan_wakaf')->nullable();
            $table->string('surat_dana_operasional')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_riwayat_hidup')->nullable();
            $table->unsignedBigInteger('organization_id');
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
        Schema::dropIfExists('organization_files');
    }
}
