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
              <button
                class="navbar-toggler border-0 py-3 lg:hidden leading-none text-xl bg-transparent text-gray-600 hover:text-gray-700 focus:text-gray-700 transition-shadow duration-150 ease-in-out mr-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContentY"
                aria-controls="navbarSupportedContentY"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <svg
                  aria-hidden="true"
                  focusable="false"
                  data-prefix="fas"
                  class="w-5"
                  role="img"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 448 512"
                >
                  <path
                    fill="currentColor"
                    d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
                  ></path>
                </svg>
              </button>
              <a class="navbar-brand text-green-700" href="#!">
                WakafKu
              </a>
            </div>
            <div class="navbar-collapse collapse grow items-center" id="navbarSupportedContentY">
              <ul class="navbar-nav mr-auto lg:flex lg:flex-row">
                <li class="nav-item">
                  <a class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out" href="#!" data-mdb-ripple="true" data-mdb-ripple-color="light">Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out" href="#!" data-mdb-ripple="true" data-mdb-ripple-color="light">Team</a>
                </li>
                <li class="nav-item mb-2 lg:mb-0">
                  <a class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out" href="#!" data-mdb-ripple="true" data-mdb-ripple-color="light">Projects</a>
                </li>
              </ul>
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
