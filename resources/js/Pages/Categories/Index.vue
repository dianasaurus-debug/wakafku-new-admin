<template>
  <div>
    <Head title="Kategori Program Wakaf" />
    <h1 class="mb-8 text-3xl font-bold">Kategori Program Wakaf</h1>
    <div class="flex items-center justify-between mb-6">
<!--      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">-->
<!--        <label class="block text-gray-700">Role:</label>-->
<!--        <select v-model="form.role_id" class="form-select mt-1 w-full">-->
<!--          <option :value="null" />-->
<!--          <option value="program">User</option>-->
<!--          <option value="role_id">Role</option>-->
<!--        </select>-->

<!--      </search-filter>-->
      <Link class="btn-indigo" href="/categories/create">
        <span>Tambah</span>
        <span class="hidden md:inline">&nbsp;Kategori</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nama</th>
          <th class="pb-4 pt-6 px-6">Label</th>
          <th class="pb-4 pt-6 px-6">Desc</th>
        </tr>
        <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/categories/${category.id}/edit`">
              {{ category.name }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/categories/${category.id}/edit`" tabindex="-1">
              {{ category.label }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/categories/${category.id}/edit`" tabindex="-1">
              {{ category.desc }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/categories/${category.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="categories.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No categories found.</td>
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
    categories: Array,
  },
  data() {
    return {
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
        this.$inertia.get('/categories', pickBy(this.form), { preserveState: true })
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
