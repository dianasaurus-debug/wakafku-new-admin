<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/admin">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" v-if="auth.user.status=='approved'" href="/programs">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('programs') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('programs') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Program</div>
      </Link>
    </div>
    <div class="mb-4" v-if="auth.user.role_id==1">
      <Link class="group flex items-center py-3" href="/categories">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('categories') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('categories') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Kategori</div>
      </Link>
    </div>
    <div class="mb-4" v-if="auth.user.role_id==1">
      <Link class="group flex items-center py-3" href="/organizations">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Lembaga</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" v-if="auth.user.status=='approved'" href="/transactions">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('transactions') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('transactions') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Pembayaran</div>
      </Link>
    </div>
    <div class="mb-4" v-if="auth.user.role_id==1">
      <Link class="group flex items-center py-3" href="/users">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('users') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('users') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">User</div>
      </Link>
    </div>

  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  props: {
    auth: Object,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
