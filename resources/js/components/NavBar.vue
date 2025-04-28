<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const checkUrl = ref((url: string) => {
  if (page.url === url) {
    return ' border-b-3 border-b-blue-900';
  }
});
</script>

<template>
  <nav class="flex flex-row justify-between gap-12 border border-b-2 border-gray-300 px-20 py-4">
    <div id="logo_app" class="flex flex-row gap-2">
      <div id="logo" class="h-6 w-6 bg-blue-900"></div>
      <div id="text" class="flex flex-col">
        <p class="text-2xl leading-none">Magang</p>
        <p class="text-xs">with BAPPEDA</p>
      </div>
    </div>
    <div id="navigation" class="flex flex-1 flex-row gap-4">
      <Link :href="route('home')" class="inline-block px-2 py-3">
        <div :class="checkUrl('/')">Beranda</div>
      </Link>
      <Link :href="route('tentang')" class="inline-block px-2 py-3">
        <div :class="checkUrl('/tentang')">Tentang</div>
      </Link>
      <Link :href="route('mahasiswa')" class="inline-block px-2 py-3">
        <div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div>
      </Link>
      <Link :href="route('pendaftaran')" class="inline-block px-2 py-3">
        <div :class="checkUrl('/pendaftaran')">Pendaftaran</div>
      </Link>
    </div>
    <div id="cta_button" class="flex flex-row items-center gap-4">
      <Button size="lg" class="bg-transparent px-2 py-3 font-medium text-blue-900 outline outline-blue-900 hover:bg-blue-900 hover:text-gray-50">
        <Link :href="route('login')" class=""> Login </Link>
      </Button>
      <Button size="lg" class="bg-blue-900 px-2 py-3 font-medium text-gray-50 hover:bg-gray-900">
        <Link :href="route('register')" class=""> Daftar </Link>
      </Button>
    </div>
  </nav>
</template>
