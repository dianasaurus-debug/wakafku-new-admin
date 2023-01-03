<template>
  <div>
    <Head title="Welcome to WakafKu" />
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
              <a type="button" class="inline-block px-6 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light" href="/login">Login</a>
            </div>
          </div>
        </nav>

        <div class="px-6 py-12 md:px-12 bg-gray-50 text-gray-800 text-center lg:text-left">
          <div class="container mx-auto xl:px-32">
            <flash-messages />
            <div class="grid lg:grid-cols-2 gap-12 flex items-center">
              <div class="mt-12 lg:mt-0">
                <h1 class="text-5xl md:text-6xl xl:text-7xl font-bold tracking-tight mb-12">Segera daftarkan <br /><span class="text-blue-600">Lembaga Wakaf Anda</span></h1>
                <a class="inline-block px-7 py-3 mr-2 bg-green-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light" href="/lembaga/daftar" role="button">Get started</a>
              </div>
              <div class="mb-12 lg:mb-0">
                <img
                  src="/images/mosque.jpg"
                  class="w-full rounded-lg shadow-lg"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Section: Design Block -->

    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'
import FlashMessages from "@/Shared/FlashMessages.vue";


export default {
  components: {
    Head,
    FlashMessages
  },
}
</script>
