<template>
  <div>
    <Head title="Tambah Report"/>
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600">Report untuk {{program.title}}</Link>

    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden py-5 px-5">
      <form @submit.prevent="store">
        <div class="flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 w-full lg:w-1/2" label="Judul"/>
        </div>
        <div class="p-4 max-h-150">
          <h4 class="mb-2 font-bold">Deskripsi</h4>
          <vue-editor
            v-model="form.desc"
            :customModules="customModulesForEditor"
            :editorOptions="editorSettings"/>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Tambah Report</loading-button>
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
  props: {
    program: Object,
  },
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
        title: '',
        desc: '',
        program_id : this.program.id,
      }),

      key: 1
    }
  },

  methods: {
    store() {
      this.form.post('/reports')
    },
  },
}

</script>
