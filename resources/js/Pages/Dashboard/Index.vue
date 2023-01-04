<template>
  <div>
    <Head title="Dashboard" />
    <div v-if="organization!=null">
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
    <div v-else>
      <div class="mx-auto flex justify-content-evenly mb-10">
        <div class="w-1/4 mr-3 rounded overflow-hidden shadow-lg bg-green-500">
          <div class="p-6">
            <div class="font-bold text-xl mb-2 text-white">Total Program Wakaf</div>
            <p class="text-white text-5xl">
              {{total_program}}
            </p>
          </div>

        </div>
        <div class="w-1/4 mr-3 rounded overflow-hidden shadow-lg" style="background: dodgerblue">
          <div class="p-6">
            <div class="font-bold text-xl mb-2 text-white">Total Dompet Wakaf</div>
            <p class="text-white text-2xl">
              {{total_transaction}}
            </p>
          </div>

        </div>
        <div class="w-1/4 mr-3 rounded overflow-hidden shadow-lg" style="background: cadetblue;">
          <div class="p-6">
            <div class="font-bold text-xl mb-2 text-white">Total Wakif</div>
            <p class="text-white text-5xl">
              {{total_waqif}}
            </p>
          </div>

        </div>
        <div class="w-1/4 rounded overflow-hidden shadow-lg" style="background : saddlebrown">
          <div class="p-6">
            <div class="font-bold text-xl mb-2 text-white">Total Lembaga</div>
            <p class="text-white text-5xl">
              {{total_lembaga}}
            </p>
          </div>

        </div>
      </div>
      <div>
        <LineChart :chart-data="chartData" :chart-options="chartOptions"></LineChart>
      </div>

    </div>


  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'
import LineChart from "@/Shared/LineChart.vue";

export default {
  components: {
    Head,
    LineChart
  },
  data(){
    return {
      status : {
        'waiting' : 'Menunggu',
        'approved' : 'Disetujui',
        'rejected' : 'Ditolak'
      },
      chartData: {
        labels: [ 'January', 'February', 'March' ],
        datasets: [ { data: [40, 20, 12] } ]
      },
      chartOptions: {
        responsive: true
      }
    }
  },
  props: {
    total_lembaga: Number,
    total_transaction : Number,
    total_program : Number,
    total_waqif : Number,
    organization : Object,
    auth : Object
  },
  layout: Layout,
}
</script>
