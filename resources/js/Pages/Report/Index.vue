<template>
  <div>
    <Head title="Program Wakaf" />
    <h1 class="mb-8 text-3xl font-bold">Daftar Progres {{program.title}}</h1>
    <div class="flex items-center justify-between mb-6">
      <Link class="btn-indigo" href="/reports/create">
        <span>Tambah</span>
        <span class="hidden md:inline">&nbsp;Report</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <div class="container mx-auto w-full h-full">
        <div class="relative wrap overflow-hidden p-10 h-full">
          <div class="border-2-2 absolute border-opacity-20 border-gray-700 h-full border"></div>
          <!-- right timeline -->
          <div class="mb-8 flex justify-start items-start w-full right-timeline">
            <div class="order-1 w-2"></div>
            <div class="z-20 flex mr-2 items-center order-1 bg-gray-800 shadow-xl w-5 h-5 rounded-full">
              <h1 class="mx-auto font-semibold text-lg text-white"></h1>
            </div>
            <div class="order-1 bg-gray-400 rounded-lg shadow-xl w-5/12 px-6 py-4">
              <h3 class="mb-3 font-bold text-gray-800 text-xl">Lorem Ipsum</h3>
              <p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
          </div>
          <div class="mb-8 flex justify-start items-center w-full right-timeline">
            <div class="order-1"></div>
            <div class="z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">
              <h1 class="mx-auto font-semibold text-lg text-white">1</h1>
            </div>
            <div class="order-1 bg-gray-400 rounded-lg shadow-xl w-5/12 px-6 py-4">
              <h3 class="mb-3 font-bold text-gray-800 text-xl">Lorem Ipsum</h3>
              <p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
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

  },
}
</script>
