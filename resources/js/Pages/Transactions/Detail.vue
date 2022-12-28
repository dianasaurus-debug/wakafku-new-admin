<template>
  <div>
    <Head title="Detail Pembayaran Wakaf"/>
    <h1 class="mb-8 text-3xl font-bold">
      Detail Pembayaran Wakaf
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden py-5 px-5">
      <table class="w-3/4 whitespace-nowrap">
        <tbody>
        <tr>
          <td class="font-bold">Program Wakaf : </td>
          <td><Link :href="'/programs/edit/'+transaction.program.id">{{transaction.program.title}}</Link></td>
        </tr>
        <tr>
          <td class="font-bold  py-4">Nominal</td>
          <td>{{'Rp'+transaction.amount}}</td>
        </tr>
        <tr>
          <td class="font-bold  py-4">Status : </td>
          <td>{{ status[transaction.status] }}
          </td>
        </tr>
        <tr>
          <td class="font-bold py-4">Tanggal Bayar : </td>
          <td>{{transaction.paid_at!=null ? formatDate(transaction.paid_at) : 'Belum lunas'}}</td>
        </tr>
        <tr>
          <td class="font-bold py-4">Jenis Wakaf : </td>
          <td>{{transaction.jenis_wakaf.toUpperCase()}}</td>
        </tr>
        <tr>
          <td class="font-bold py-4">Metode Pembayaran : </td>
          <td>{{transaction.payment_method.name}} ({{transaction.payment_method.kind.toUpperCase()}})</td>
        </tr>
        <tr>
          <td class="font-bold py-4">Nama Wakif : </td>
          <td>{{transaction.waqif.user.name}}</td>
        </tr>
        <tr>
          <td class="font-bold">E-Mail Wakif : </td>
          <td>{{transaction.waqif.user.email}}</td>
        </tr>
        <div v-if="transaction.jenis_wakaf=='berjangka'">
          <tr>
            <td class="font-bold py-4">Jangka Waktu : </td>
            <td>{{transaction.berjangka_data.jangka+' tahun'}}</td>
          </tr>
          <tr>
            <td class="font-bold">Tanggal Pengembalian : </td>
            <td>{{formatDate(transaction.berjangka_data.returned_at)}})</td>
          </tr>
          <tr>
            <td class="font-bold">Nomor Rekening : </td>
            <td>{{formatDate(transaction.berjangka_data.returned_at)}})</td>
          </tr>
          <tr>
            <td class="font-bold">Tanggal Pengembalian : </td>
            <td>{{formatDate(transaction.berjangka_data.returned_at)}})</td>
          </tr>
        </div>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import Layout from '@/Shared/Layout'
import axios from "axios";
import moment from "moment";

export default {
  components: {
    Head,
    Link,

  },
  layout: Layout,
  props: {
    transaction: Object,
  },
  data() {
    return {
      status : [
        'Pending',
        'Sukses'
      ],
    }
  },
  methods: {
    getUrl(){
      return window.location.host;
    },
    formatDate(date) {
      return moment(date).format("Do MMM YYYY")
    },
  },
}
</script>
