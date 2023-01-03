<template>
  <div>
    <Head title="Daftar Lembaga Wakaf" />
    <h1 class="mb-8 text-3xl font-bold">Lembaga Wakaf</h1>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6">Jenis</th>
          <th class="pb-4 pt-6 px-6" >Kota</th>
          <th class="pb-4 pt-6 px-6" >Status</th>

        </tr>
        <tr v-for="lembaga in organizations" :key="lembaga.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              {{ lembaga.user.name }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              {{ lembaga.user.email }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              {{ lembaga.jenis_lembaga == 'organisasi' ? 'Organisasi' : 'Individu' }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              {{ lembaga.address.kabupaten }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-3 bg-gray-200 text-gray-800 rounded-full">{{ status[lembaga.status] }}</div>
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/organizations/`+lembaga.id" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="organizations.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No users found.</td>
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
// import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    // SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    organizations: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        role_id: this.filters.role_id,
      },
      status : {
        'waiting' : 'Menunggu',
        'approved' : 'Disetujui',
        'rejected' : 'Ditolak'
      }
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/organizations', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
