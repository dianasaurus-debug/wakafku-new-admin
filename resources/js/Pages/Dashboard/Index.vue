<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Welcome!</h1>
    <div v-if="organization.status=='waiting'">
      <div class="font-bold flex justify-start"><span class="h-3 mr-2">Status : </span> <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-full">{{ status[organization.status] }}</div> </div>
      <p class="mb-8 leading-normal">Mohon menunggu lembaga Anda untuk disetujui</p>
    </div>
    <div v-if="organization.status=='rejected'">
      <div class="font-bold flex justify-start"><span class="h-3 mr-2">Status : </span> <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="px-3 py-2 bg-red-500 text-white rounded-full">{{ status[organization.status] }}</div> </div>
      <p class="mb-8 leading-normal">Mohon perbaiki data Anda atau pergi ke kantor LKS PWU terdekat </p>
      <button class="btn-indigo">Edit Data</button>
    </div>
    <div v-if="organization.status=='approved'">
     Halo sudah diapprove
    </div>

  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
  },
  data(){
    return {
      status : {
        'waiting' : 'Menunggu',
        'approved' : 'Disetujui',
        'rejected' : 'Ditolak'
      }
    }
  },
  props: {
    organization : Object,
    auth : Object
  },
  layout: Layout,
}
</script>
