<template>
  <div>
    <Head title="Pembayaran Wakaf" />
    <h1 class="mb-8 text-3xl font-bold">Pembayaran Wakaf</h1>

    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Program</th>
          <th class="pb-4 pt-6 px-6">Nominal</th>
          <th class="pb-4 pt-6 px-6">Mtd Pembayaran</th>
          <th class="pb-4 pt-6 px-6">Jenis</th>
          <th class="pb-4 pt-6 px-6">Status</th>
          <th class="pb-4 pt-6 px-6">Tanggal</th>
        </tr>
        <tr v-for="transaction in all_transactions" :key="transaction.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="'/transactions/detail/'+transaction.id">
              {{ transaction.program.title }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              Rp {{ transaction.amount }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              <img class="h-5" v-bind:src="'http://'+getUrl()+'/images/payment_logo/'+transaction.payment_method.logo">
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              {{ transaction.jenis_wakaf.toUpperCase() }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-3 bg-gray-200 text-gray-800 rounded-full">{{ status[transaction.status] }}</div>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              {{ formatDate(transaction.created_at) }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="'/transactions/detail/'+transaction.id" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="all_transactions.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No transactions found.</td>
        </tr>
      </table>
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
import SearchFilter from '@/Shared/SearchFilter'
import moment from 'moment';

export default {
  components: {
    Head,
    Icon,
    Link,
    SearchFilter,

  },
  layout: Layout,
  props: {
    filters: Object,
    all_transactions: Array,
  },
  data() {
    return {
      status : [
        'Pending',
        'Sukses'
      ],
      form: {
        search: this.filters.search,
        // category_id: this.filters.category_id,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/transactions', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    getUrl(){
      return window.location.host;
    },
    formatDate(date) {
      return moment(date).format("Do MMM YYYY")
    },
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
