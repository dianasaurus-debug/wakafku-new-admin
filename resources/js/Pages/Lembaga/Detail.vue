<template>
  <div>
    <Head title="Detail Pembayaran Wakaf"/>
    <h1 class="mb-8 text-3xl font-bold">
      Detail Lembaga Wakaf
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden py-5 px-5">
      <table class="w-3/4">
        <tbody>
        <tr>
          <h3 class="font-bold py-3">Detail Data Lembaga</h3>
        </tr>
        <tr>
          <td class="font-bold text-left">Nama Lembaga </td>
          <td class="text-left">: {{lembaga.user.name}}</td>
          <td class="font-bold text-left">E-Mail </td>
          <td class="text-left">: {{lembaga.user.email}}</td>
        </tr>
        <tr>
          <td class="font-bold">Status </td>
          <td>: {{ status[lembaga.status] }}</td>
          <td class="font-bold">Dibuat pada </td>
          <td> : {{formatDate(lembaga.created_at)}}</td>
        </tr>
        <tr>
          <td class="font-bold">Jenis Lembaga </td>
          <td> : {{ lembaga.jenis_lembaga == 'organisasi' ? 'Organisasi' : 'Individu' }}</td>
        </tr>


        </tbody>
      </table>

      <table class="table-fixed">
        <tbody>
        <tr>
          <h3 class="font-bold py-3">Berkas Persyaratan</h3>
        </tr>
        <tr v-for="doc in document_list">
          <td class="font-bold flex justify-start items-center">
            <button data-bs-toggle="modal" data-bs-target="#open_doc" @click="openModal(doc.name, lembaga.file[doc.label])" class="mr-3 inline-block p-3 bg-green-600 text-white font-medium text-sm rounded shadow-md" role="button">Lihat</button>
            <span class="font-bold">{{ doc.name }}</span>
          </td>
        </tr>
        <tr v-if="lembaga.status=='waiting'">
          <td class="font-bold py-4 flex justify-start" colspan="4">
            <span class="mr-3">
              Actions :
            </span>
            <div><button class="inline-block p-3 mr-2 bg-green-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light" @click="approveOrganization">Setujui</button>
              <a class="inline-block p-3 mr-2 bg-red-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light" href="/lembaga/daftar" role="button">Tolak</a>
            </div>
          </td>

        </tr>
        </tbody>
      </table>
    </div>

    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="open_doc" tabindex="-1" aria-labelledby="open_docLabel" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg relative w-auto pointer-events-none">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
          <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLgLabel">
              {{recent_doc}}
            </h5>
            <button type="button"
                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                    data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body relative p-4">
            <pdf :src="used_path"></pdf>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'
import axios from "axios";
import moment from "moment";
import pdf from 'vue-pdf'


export default {
  components: {
    Head,
    Link,
    pdf

  },
  layout: Layout,
  props: {
    lembaga: Object,
  },
  computed: {
    used_path(){
      return '/pdf/'+this.recent_path;
    }
  },
  data() {
    return {
      is_show : false,
      recent_doc : '',
      recent_path : '',
      status : {
        'waiting' : 'Menunggu',
        'approved' : 'Disetujui',
        'rejected' : 'Ditolak'
      },
      document_list : [
        {
          'label' : 'akta_pendirian',
          'name' : 'Akta Pendirian'
        },
        {
          'label' : 'company_profile',
          'name' : 'Company Profile'
        },
        {
          'label' : 'npwp',
          'name' : 'NPWP Nazhir'
        },
        {
          'label' : 'pengesahan_kemenkumham',
          'name' : 'Dokumen Pengesahan Kemenkumham'
        },
        {
          'label' : 'rekomendasi_lkspwu',
          'name' : 'Dokumen Rekomendasi LKSPWU'
        },
        {
          'label' : 'keterangan_dom',
          'name' : 'Dokumen Surat Keterangan Domisili dari Kelurahan'
        },
        {
          'label' : 'sertif_kompetensi',
          'name' : 'Memiliki Sertifikat Kompetensi Bidang Pengelola Wakaf Minimal 2 Orang'
        },
        {
          'label' : 'rencana_kerja',
          'name' : 'Rencana Kerja'
        },
        {
          'label' : 'surat_permohonan',
          'name' : 'Surat Permohonan'
        },
        {
          'label' : 'surat_pernyataan_diaudit',
          'name' : 'Surat Pernyataan Bersedia Diaudit'
        },
        {
          'label' : 'surat_wakaf_bulanan',
          'name' : 'Surat Pernyataan Laporan Data Wakaf Bulanan'
        },
        {
          'label' : 'surat_pelaksanaan_wakaf',
          'name' : 'Surat Pernyataan Laporan Pelaksaan Wakaf per 6 bulan'
        },
        {
          'label' : 'surat_dana_operasional',
          'name' : 'Surat Pernyataan Mempunyai Dana Operasional min. Rp 30 juta'
        },


      ]
    }
  },
  methods: {
    openModal(document_name, doc_path){
      console.log(doc_path);
      this.recent_path = doc_path;
      this.recent_doc = document_name;
      this.is_show = true;
    },
    getUrl(){
      return window.location.host;
    },
    approveOrganization(){
      this.$swal.fire({
        title: 'Apakah Anda yakin ingin approve lembaga ini?',
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Setujui',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          axios
            .get('/organizations/approve/'+this.lembaga.id)
            .then(response => {
              if(response.data.success==true){
                this.$swal.fire('Disetujui!', '', response.data.message)
              } else {
                this.$swal.fire('Gagal disetujui!', '', response.data.message)
              }
            })
        }
      })
    },
    formatDate(date) {
      return moment(date).format("Do MMM YYYY")
    },
  },
}
</script>
