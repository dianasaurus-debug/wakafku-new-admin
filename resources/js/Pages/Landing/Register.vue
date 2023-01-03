<template>
  <div>
    <Head title="Pendaftaran Lembaga Wakaf"/>
    <!-- Container for demo purpose -->
    <div>

      <!-- Section: Design Block -->
      <section class="mb-40">
        <nav class="navbar navbar-expand-lg shadow-md py-2 bg-white relative flex items-center w-full justify-between">
          <div class="px-6 w-full flex flex-wrap items-center justify-between">
            <div class="flex items-center">
              <a class="navbar-brand text-green-700" href="#!">
                WakafKu
              </a>
            </div>
            <div class="flex items-center lg:ml-auto">
              <button type="button"
                      class="inline-block px-6 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                      data-mdb-ripple="true" data-mdb-ripple-color="light">Login
              </button>
            </div>
          </div>
        </nav>

        <div class="px-6 py-12 md:px-12 bg-gray-50 text-gray-800 text-center lg:text-left">
          <div class="container mx-auto xl:px-32">
            <flash-messages />
            <h3 class="mt-5 text-2xl md:text-4xl xl:text-5xl font-bold tracking-tight mb-12">Formulir Pendaftaran Lembaga
              Wakaf</h3>
            <form class="w-full"  @submit.prevent="store">
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
                    <select  v-model="form.jenis_lembaga" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                  <input  v-model="form.phone" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="number">

                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                    Website
                  </label>
                  <input  v-model="form.website" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text">

                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                    Tahun Berdiri
                  </label>
                  <input  v-model="form.tahun_berdiri" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="number">

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
                    <select @change="pickProvince"  v-model="address.province" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                    <select @change="pickCity"  v-model="address.city" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                    <select @change="pickDistrict"  v-model="address.district" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                    <select @change="pickVillage"  v-model="address.village" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.company_profile" :error="form.errors.cover" class="w-full"
                              type="file" label="Profil Lembaga"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.akta_pendirian" :error="form.errors.akta_pendirian" class="w-full"
                              type="file" label="Akta Pendirian"/>
                </div>

              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.pengesahan_kemenkumham" :error="form.errors.pengesahan_kemenkumham" class="w-full"
                              type="file" label="Dokumen Pengesahan Kemenkumham"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.rekomendasi_lkspwu" :error="form.errors.rekomendasi_lkspwu" class="w-full"
                              type="file" label="Dokumen Rekomendasi LKSPWU"/>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.npwp" :error="form.errors.npwp" class="w-full"
                              type="file" label="Dokumen NPWP"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.keterangan_dom" :error="form.errors.keterangan_dom" class="w-full"
                              type="file" label="Dokumen Surat Keterangan Domisili dari Kelurahan"/>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.sertif_kompetensi" :error="form.errors.sertif_kompetensi" class="w-full"
                              type="file" label="Sertifikat Kompetensi Bidang Pengelola Wakaf"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.rencana_kerja" :error="form.errors.rencana_kerja" class="w-full"
                              type="file" label="Rencana Kerja"/>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.surat_permohonan" :error="form.errors.surat_permohonan" class="w-full"
                              type="file" label="Surat Permohonan"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.surat_pernyataan_diaudit" :error="form.errors.surat_pernyataan_diaudit" class="w-full"
                              type="file" label="Surat Pernyataan Bersedia Diaudit"/>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.surat_wakaf_bulanan" :error="form.errors.surat_wakaf_bulanan" class="w-full"
                              type="file" label="Surat Pernyataan Laporan Data Wakaf Bulanan"/>
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.surat_pelaksanaan_wakaf" :error="form.errors.surat_pelaksanaan_wakaf" class="w-full"
                              type="file" label="Surat Pernyataan Laporan Pelaksaan Wakaf per 6 bulan"/>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <file-input v-model="form.surat_dana_operasional" :error="form.errors.surat_dana_operasional" class="w-full"
                              type="file" label="Surat Pernyataan Mempunyai Dana Operasional min. Rp 30 juta"/>
                </div>
              </div>
              <div class="flex justify-end -mx-3 mb-6">
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Daftar</loading-button>
              </div>

            </form>
          </div>
        </div>
      </section>
      <!-- Section: Design Block -->

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

export default {
  mounted() {
    this.getProvinces();
  },
  methods: {
    getProvinces() {
      axios.get('/api/provinces')
        .then((res) => {
          this.provinces = res.data.data
        })
    },
    pickProvince(event) {
      this.address.province = event.target.value;
      console.log(event.target.value);
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

  components: {
    Head,
    FileInput,
    TextareaInput,
    LoadingButton,
    FlashMessages
  },
  data() {
    return {
      remember: 'form',
      address: {
        province: '',
        city: '',
        district: '',
        village: '',
        postalcode: '',
        jenis: '',
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
        nama_lengkap: '',
        password: '',
        email: '',
        tahun_berdiri: '',
        jenis_lembaga: '',
        alamat_detail: '',
        profil_organisasi: '',
        website: '',
        address_id: '',
        phone : '',
        akta_pendirian : null,
        company_profile : null,
        npwp : null,
        pengesahan_kemenkumham : null,
        rekomendasi_lkspwu : null,
        keterangan_dom : null,
        sertif_kompetensi : null,
        rencana_kerja : null,
        surat_permohonan : null,
        surat_pernyataan_diaudit : null,
        surat_wakaf_bulanan : null,
        surat_pelaksanaan_wakaf : null,
        surat_dana_operasional : null,
        file_ktp : null,
        file_riwayat_hidup : null,
      }),

      key: 1,

    }
  },




}
</script>
