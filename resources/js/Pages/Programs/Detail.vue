<template>
  <div>
    <Head title="Detail Program Wakaf"/>
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/categories">Program Wakaf</Link>
      <span class="text-indigo-400 font-medium">/</span> Detail
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden py-5 px-5">
        <div class="flex flex-wrap">
          <text-input disabled="true" v-model="form.title" :error="form.errors.title" class="pr-6 w-full lg:w-1/2" label="Nama"/>
          <select-input disabled="true" v-model="form.category_id" :error="form.errors.category_id" class="pr-6 w-full lg:w-1/2"
                        label="Kategori">
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <text-input v-model="form.target" :error="form.errors.target" class="pr-6 w-full lg:w-1/2" label="Target Dana (Rp)"/>
        </div>
        <div class="p-4 max-h-150">
          <h4 class="mb-2 font-bold">Deskripsi</h4>
          <vue-editor
            v-model="form.desc"
            :customModules="customModulesForEditor"
            :editorOptions="editorSettings"/>
        </div>
        <h3 class="mb-3 mt-3 font-bold">Alamat Program Wakaf</h3>
        <div class="flex flex-wrap">
          <div class="pr-6 pb-4 w-full lg:w-1/2 ">
            <label class="form-label font-bold">Provinsi:</label>
            <select v-model="address.province" @change="pickProvince($event)" class="form-select">
              <option v-for="province in provinces" :value="province.provinsi">{{ province.provinsi }}</option>
            </select>
          </div>
          <div class="pr-6 pb-4  w-full lg:w-1/2 ">
            <label class="form-label font-bold">Kabupaten:</label>
            <select v-model="address.city" :disabled="cities.length===0" @change="pickCity($event)" class="form-select">
              <option v-for="city in cities" :value="city">{{ city.kabupaten }}</option>
            </select>
          </div>
          <div class="pr-6 pb-4 w-full lg:w-1/2 ">
            <label class="form-label font-bold">Kecamatan:</label>
            <select v-model="address.district" :disabled="districts.length===0" @change="pickDistrict($event)" class="form-select">
              <option v-for="district in districts" :value="district">{{ district.kecamatan }}</option>
            </select>
          </div>
          <div class="pr-6 pb-4 w-full lg:w-1/2 ">
            <label class="form-label font-bold">Desa/Kelurahan:</label>
            <select v-model="address.village" :disabled="villages.length===0" @change="pickVillage($event)"
                    class="form-select">
              <option v-for="village in villages" :value="village">{{ village.kelurahan }}</option>
            </select>
          </div>
          <text-input v-model="address.postalcode" class="pr-6 pb-4 w-full lg:w-1/2" label="Kode Pos"
                      aria-readonly="true"/>

          <div class="flex flex-col w-full lg:w-1/2">
            <file-input v-model="form.cover" :error="form.errors.cover" class="pr-6 pb-8 w-full lg:w-1/2"
                        type="file" accept="image/*" label="Cover Program Wakaf"/>
            <div>
              <img v-bind:src="'http://'+getUrl()+'/img/'+program.cover">
            </div>
          </div>
          <TextareaInput class="pr-6 pb-4 w-full lg:w-1/2" label="Alamat Detail" v-model="form.address_detail"></TextareaInput>
        </div>
        <h3 class="my-3 font-bold">Berkas Persyaratan</h3>
        <div class="flex flex-wrap" v-if="auth.user.role_id!=1">
          <div class="flex items-end w-full lg:w-1/2 pr-4 mb-2">
            <file-input class="flex-1" v-model="form.surat_permohonan_wakaf" :error="form.errors.surat_permohonan_wakaf"
                        type="file" label="Surat Permohonan Wakaf"/>
            <button class="ml-2 btn-indigo">Lihat</button>
          </div>
          <div class="flex items-end w-full lg:w-1/2 pr-4 mb-2">
            <file-input class="flex-1" v-model="form.surat_pendaftaran_wakaf" :error="form.errors.surat_pendaftaran_wakaf"
                        type="file" label="Surat Pendaftaran Wakaf"/>
            <button class="ml-2 btn-indigo">Lihat</button>
          </div>
          <div class="flex items-end w-full lg:w-1/2 pr-4 mb-2">
            <file-input class="flex-1" v-model="form.ikrar_wakaf" :error="form.errors.ikrar_wakaf"
                        type="file" label="Ikrar Wakaf"/>
            <button class="ml-2 btn-indigo">Lihat</button>
          </div>
          <div class="flex items-end w-full lg:w-1/2 pr-4 mb-2">
            <file-input class="flex-1" v-model="form.proposal_program" :error="form.errors.proposal_program"
                        type="file" label="Proposal Program Wakaf"/>
            <button class="ml-2 btn-indigo">Lihat</button>
          </div>
        </div>
        <h4 class="mb-2 mt-3 font-bold">Letak Koordinat Tempat Program Wakaf</h4>
        <div class="flex justify-start">
          <div class="mr-5" style="width:50%;height: 300px">
            <LocationPicker v-model="form.location" :key="key" />
          </div>
          <div>
            <text-input v-model="form.location.position.lat" aria-readonly="true" class="w-full" label="Latitude"/>
            <text-input v-model="form.location.position.lng" aria-readonly="true"  class="w-full" label="Longitude"/>
          </div>
        </div>

        <div class="flex items-center justify-between px-8 py-4 bg-gray-50 border-t border-gray-100">
          <div>
            <a class="btn-indigo" :href="'/reports?program_id='+program.id">Laporan</a>
          </div>
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan Program</loading-button>
        </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import FileInput from '@/Shared/FileInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TextareaInput from "@/Shared/TextareaInput.vue";
import LocationPicker from "@/Shared/LocationPicker.vue";
import {VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module--fix-imports-error'
import axios from "axios";

export default {
  components: {
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
    LocationPicker,
    VueEditor
  },
  layout: Layout,
  props: {
    program: Object,
    categories: Array,
    auth : Object
  },
  remember: 'form',
  mounted() {
    this.getProvinces();
    this.pickProvince();
    this.pickCity();
    this.pickDistrict();
    this.pickVillage();
  },
  data() {
    return {
      address: {
        province: this.program.address.provinsi,
        city: {
          'jenis' : this.program.address.jenis,
          'kabupaten' : this.program.address.kabupaten,
          'provinsi' : this.program.address.provinsi
        },
        district: {
          'kecamatan' : this.program.address.kecamatan,
          'kabupaten' : this.program.address.kabupaten,
          'jenis' : this.program.address.jenis,
          'provinsi' : this.program.address.provinsi,
        },
        village: {
          'id' : this.program.address.id,
          'kelurahan' : this.program.address.kelurahan,
          'kecamatan' : this.program.address.kecamatan,
          'kabupaten' : this.program.address.kabupaten,
          'jenis' : this.program.address.jenis,
          'provinsi' : this.program.address.provinsi,
        },
        postalcode: this.program.address.kodepos.toString(),
        jenis: this.program.address.jenis,
      },
      customModulesForEditor: [
        {alias: "imageDrop", module: ImageDrop},
        {alias: "imageResize", module: ImageResize}
      ],
      provinces: [],
      cities: [],
      districts: [],
      villages: [],
      postal_code: '',
      editorSettings: {
        modules: {
          imageDrop: true,
          imageResize: {}
        }
      },
      key: 1,
      form: this.$inertia.form({
        _method: 'put',
        title: this.program.title,
        desc: this.program.desc,
        address_detail: this.program.address_detail,
        location: {
          address : '',
          position : {
            lat: this.program.latitude,
            lng: this.program.longitude,
          }
        },
        target : this.program.target,
        cover: null,
        surat_permohonan_wakaf: null,
        surat_pendaftaran_wakaf: null,
        ikrar_wakaf: null,
        proposal_program: null,
        terkumpul: this.program.terkumpul,
        category_id: this.program.category_id,
        address_id: this.program.address_id,
      }),
    }
  },
  methods: {
    getUrl(){
      return window.location.host;
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

  },
}
</script>
