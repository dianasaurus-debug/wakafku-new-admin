<template>
  <div>
    <Head title="Tambah Kategori Program Wakaf"/>
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/categories">Kategori</Link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden py-5 px-5">
      <form @submit.prevent="store">
        <div class="flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 w-full lg:w-1/2" label="Nama"/>
          <text-input v-model="form.label" :error="form.errors.label" class="pr-6 w-full lg:w-1/2" label="Label"/>

        </div>
        <div class="p-4 max-h-150">
          <h4 class="mb-2 font-bold">Deskripsi</h4>
          <vue-editor
            v-model="form.desc"
            :customModules="customModulesForEditor"
            :editorOptions="editorSettings"/>
        </div>
        <file-input v-model="form.image" :error="form.errors.image" class="pr-6 pb-8 w-full lg:w-1/2"
                    type="file" accept="image/*" label="Icon Kategori"/>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Tambah Kategori</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'
import FileInput from '@/Shared/FileInput'
import TextInput from '@/Shared/TextInput'
import TextareaInput from "@/Shared/TextareaInput";
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import {VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module--fix-imports-error'
import axios from "axios";
import LocationPicker from "@/Shared/LocationPicker";


export default {
  components: {
    TextareaInput,
    LocationPicker,
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    VueEditor,

  },
  layout: Layout,
  remember: 'form',
  mounted() {
    this.getProvinces();
  },

  data() {
    return {
      customModulesForEditor: [
        {alias: "imageDrop", module: ImageDrop},
        {alias: "imageResize", module: ImageResize}
      ],
      editorSettings: {
        modules: {
          imageDrop: true,
          imageResize: {}
        }
      },
      form: this.$inertia.form({
        name: '',
        label: '',
        image: null,
        desc : ''

      }),

      key: 1
    }
  },

  methods: {

    reset() {
      this.key += 1;
      this.location = {};
    },

    store() {
      this.form.post('/categories')
    },
  },
}

</script>
