<template>
  <div>
    <Head title="Program Wakaf" />
    <h1 class="mb-8 text-3xl font-bold">Daftar Progres {{program.title}}</h1>
    <div class="flex items-center justify-between mb-6">
      <Link class="btn-indigo" :href="'/reports/create?program_id='+program.id">
        <span>Tambah</span>
        <span class="hidden md:inline">&nbsp;Report</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item bg-white border border-gray-200" v-for="report in reports">
          <h2 class="accordion-header mb-0" id="headingOne">
            <button class="
        accordion-button
        relative
        flex
        items-center
        w-full
        py-4
        px-5
        text-base text-gray-800 text-left
        bg-white
        border-0
        rounded-none
        transition
        focus:outline-none
      " type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+report.id" aria-expanded="true"
                    :aria-controls="'collapse-'+report.id">
              ({{formatDate(report.date_created)}}) <b>{{report.title}}</b>
            </button>
          </h2>
          <div :id="'collapse-'+report.id" class="accordion-collapse collapse show" aria-labelledby="headingOne"
               data-bs-parent="#accordionExample">
            <div class="accordion-body py-4 px-5" v-html="report.desc">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import moment from "moment";

export default {
  components: {
    Head,
    Icon,
    Link,
  },
  layout: Layout,
  props: {
    program: Object,
    reports: Array,
  },
  data() {
    return {

    }
  },
  methods: {
    formatDate(date) {
      return moment(date).format("Do MMM YYYY")
    },
  },
}
</script>
