<template>
  <div>
    <Head title="Detail Data Lembaga Wakaf"/>
    <!-- Container for demo purpose -->
    <div class="p-4 text-gray-800 text-center lg:text-left">
      <div class="container mx-auto">
        <flash-messages/>
        <h3 class="mt-5 text-2xl font-bold tracking-tight mb-12">Edit Data Lembaga Wakaf</h3>
          <h4 class="font-bold tracking-tight mb-8">Detail Akun</h4>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-first-name">
                Nama Lembaga
              </label>
              <input
                v-model="form.nama_lengkap"
                class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                id="grid-first-name" type="text">
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-state">
                Jenis Lembaga
              </label>
              <div class="relative">
                <select v-model="form.jenis_lembaga"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                  <option :value="jenis.id" v-for="jenis in list_jenis">{{ jenis.label }}</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-first-name">
                E-Mail
              </label>
              <input
                v-model="form.email"
                class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                id="grid-first-name" type="email">

            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-last-name">
                Password
              </label>
              <input
                v-model="form.password"
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="grid-last-name" type="password" placeholder="Doe">
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                No. Telepon
              </label>
              <input v-model="form.phone"
                     class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                     id="grid-first-name" type="number">

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                Website
              </label>
              <input v-model="form.website"
                     class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                     id="grid-first-name" type="text">

            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                Tahun Berdiri
              </label>
              <input v-model="form.tahun_berdiri"
                     class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                     id="grid-first-name" type="number">

            </div>
          </div>

          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
              <TextareaInput label="Alamat Detail" v-model="form.alamat_detail"></TextareaInput>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
              <TextareaInput label="Profil Lembaga" v-model="form.profil_organisasi"></TextareaInput>
            </div>
          </div>
          <h4 class="font-bold tracking-tight mb-8">Detail Alamat</h4>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-state">
                Provinsi
              </label>
              <div class="relative">
                <select @change="pickProvince" v-model="address.province"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                  <option :value="province.provinsi" v-for="province in provinces">{{ province.provinsi }}</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-state">
                Kota
              </label>
              <div class="relative">
                <select @change="pickCity" v-model="address.city"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                  <option :value="city" v-for="city in cities">{{ city.kabupaten }}</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-state">
                Kecamatan
              </label>
              <div class="relative">
                <select @change="pickDistrict" v-model="address.district"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                  <option :value="district" v-for="district in districts">{{ district.kecamatan }}</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-state">
                Desa/Kelurahan
              </label>
              <div class="relative">
                <select @change="pickVillage" v-model="address.village"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                  <option :value="village" v-for="village in villages">{{ village.kelurahan }}</option>
                </select>
                <div
                  class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                     for="grid-first-name">
                Kode Pos
              </label>
              <input
                v-model="address.postalcode"
                class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                id="grid-first-name" type="text">
            </div>
          </div>

          <h4 class="font-bold tracking-tight mb-8">Persyaratan Berkas</h4>
          <div class="flex flex-wrap -mx-3 mb-6">
            <div v-for="doc in document_list" class="w-full flex justify-start items-end md:w-1/2 px-3 mb-6 md:mb-0">
              <file-input v-model="form[doc]" :error="form.errors[doc]" class="flex-1"
                          type="file" :label="doc.name"/>
              <button class="ml-2 btn-indigo" data-bs-toggle="modal" data-bs-target="#open_doc" @click="openModal(doc.name, lembaga.file[doc.label])">Lihat</button>
            </div>
          </div>
          <div class="flex justify-between -mx-3 mb-6">
            <div v-if="lembaga.status!='approved'">
                <div><button @click="approveOrganization" type="button" class="inline-block p-3 mr-2 bg-green-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light" v-if="lembaga.status=='waiting' || lembaga.status=='rejected'">Setujui</button>
                  <button @click="rejectOrganization" type="button" class="inline-block p-3 mr-2 bg-red-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light"  v-if="lembaga.status=='waiting'">Tolak</button>
                </div>
            </div>
            <div>
              <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan</loading-button>
            </div>
          </div>
      </div>
    </div>
    <!-- Section: Design Block -->
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
import {Head} from '@inertiajs/inertia-vue'
import FileInput from "@/Shared/FileInput.vue";
import TextareaInput from "@/Shared/TextareaInput.vue";
import axios from "axios";
import LoadingButton from "@/Shared/LoadingButton.vue";
import FlashMessages from "@/Shared/FlashMessages.vue";
import Layout from "@/Shared/Layout.vue";
import pdf from "vue-pdf";
export default {
  mounted() {
    this.getProvinces();
    this.pickProvince();
    this.pickCity();
    this.pickDistrict();
    this.pickVillage();
  },
  layout: Layout,
  methods: {
    openModal(document_name, doc_path){
      this.recent_path = doc_path;
      this.recent_doc = document_name;
      this.is_show = true;
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
    rejectOrganization(){
      this.$swal.fire({
        title: 'Apakah Anda yakin ingin menolak lembaga ini?',
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Tolak',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          axios
            .get('/organizations/reject/'+this.lembaga.id)
            .then(response => {
              if(response.data.success==true){
                this.$swal.fire('Berhasil ditolak!', '', response.data.message)
              } else {
                this.$swal.fire('Gagal ditolak!', '', response.data.message)
              }
            })
        }
      })
    },

    getProvinces() {
      axios.get('/api/provinces')
        .then((res) => {
          this.provinces = res.data.data
        })
    },
    pickProvince(event) {
      if(event!=null){
        this.address.province = event.target.value;
      }
      var url = `/api/cities?provinsi=${this.address.province}`
      axios.get(url)
        .then(res => {
          this.cities = res.data.data;
        })
    },
    pickCity(event) {
      var url = `/api/districts?provinsi=${this.address.city.provinsi}&kabupaten=${this.address.city.kabupaten}&jenis=${this.address.city.jenis}`
      axios.get(url)
        .then(res => {
          this.districts = res.data.data
        })
    },
    pickDistrict(event) {
      var url = `/api/villages?provinsi=${this.address.district.provinsi}&kabupaten=${this.address.district.kabupaten}&jenis=${this.address.district.jenis}&kecamatan=${this.address.district.kecamatan}`
      axios.get(url)
        .then(res => {
          this.villages = res.data.data
        })
    },
    pickVillage(event) {
      var city = event.target.value.kabupaten;
      var jenis = event.target.value.jenis;
      var district = event.target.value.kecamatan;
      var village = event.target.value.kelurahan;

      var url = `/api/postalcodes?provinsi=${this.address.village.provinsi}&kabupaten=${this.address.village.kabupaten}&jenis=${this.address.village.jenis}&kecamatan=${this.address.village.kecamatan}&kelurahan=${this.address.village.kelurahan}`
      axios.get(url)
        .then(res => {
          this.address.postalcode = res.data.data.kodepos
          this.form.address_id = res.data.data.id
        })
    },
    reset() {
      this.key += 1;
      this.location = {};
    },

    store() {
      this.form.post('/lembaga/daftar')
    },
  },
  props: {
    lembaga: Object,
  },
  components: {
    pdf,
    Head,
    FileInput,
    TextareaInput,
    LoadingButton,
    FlashMessages
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
      remember: 'form',
      address: {
        province: this.lembaga.address.provinsi,
        city: {
          'jenis' : this.lembaga.address.jenis,
          'kabupaten' : this.lembaga.address.kabupaten,
          'provinsi' : this.lembaga.address.provinsi
        },
        district: {
          'kecamatan' : this.lembaga.address.kecamatan,
          'kabupaten' : this.lembaga.address.kabupaten,
          'jenis' : this.lembaga.address.jenis,
          'provinsi' : this.lembaga.address.provinsi,
        },
        village: {
          'id' : this.lembaga.address.id,
          'kelurahan' : this.lembaga.address.kelurahan,
          'kecamatan' : this.lembaga.address.kecamatan,
          'kabupaten' : this.lembaga.address.kabupaten,
          'jenis' : this.lembaga.address.jenis,
          'provinsi' : this.lembaga.address.provinsi,
        },
        postalcode: this.lembaga.address.kodepos.toString(),
        jenis: this.lembaga.address.jenis,
      },
      list_jenis: [
        {
          id: 'organisasi',
          label: 'Organisasi'
        },
        {
          id: 'pribadi',
          label: 'Pribadi'
        },

      ],
      provinces: [],
      cities: [],
      districts: [],
      villages: [],
      postal_code: '',
      form: this.$inertia.form({
        nama_lengkap: this.lembaga.user.name,
        password: '',
        email: this.lembaga.user.email,
        tahun_berdiri: this.lembaga.tahun_berdiri,
        jenis_lembaga: this.lembaga.jenis_lembaga,
        alamat_detail: this.lembaga.alamat_detail,
        profil_organisasi: this.lembaga.profil_organisasi,
        website: this.lembaga.website,
        address_id: this.lembaga.address_id,
        phone: this.lembaga.phone,
        akta_pendirian: null,
        company_profile: null,
        npwp: null,
        pengesahan_kemenkumham: null,
        rekomendasi_lkspwu: null,
        keterangan_dom: null,
        sertif_kompetensi: null,
        rencana_kerja: null,
        surat_permohonan: null,
        surat_pernyataan_diaudit: null,
        surat_wakaf_bulanan: null,
        surat_pelaksanaan_wakaf: null,
        surat_dana_operasional: null,
        file_ktp: null,
        file_riwayat_hidup: null,
      }),
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


      ],
      key: 1,

    }
  },


}
</script>
