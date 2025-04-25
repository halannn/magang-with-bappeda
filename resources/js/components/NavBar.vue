<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const checkUrl = ref((url: string) => {
  if (page.url === url) {
    return (' border-b-2 border-b-blue-900');
  }
})
</script>

<template>
  <nav class="flex flex-row justify-between gap-12 py-4 px-20 border border-b-2 border-gray-300">
    <div id="logo_app" class="flex flex-row gap-2 ">
      <div id="logo" class="bg-blue-900 w-6 h-6"></div>
      <div id="text" class="flex flex-col">
        <p class="text-2xl leading-none">Magang</p>
        <p class="text-xs">with BAPPEDA</p>
      </div>
    </div>
    <div id="navigation" class="flex flex-row gap-4 flex-1">
      <Link :href="route('home')" class="inline-block px-2 py-3 ">
      <div :class="checkUrl('/')"> Beranda </div>
      </Link>
      <Link :href="route('tentang')" class="inline-block px-2 py-3 ">
      <div :class="checkUrl('/tentang')"> Tentang </div>
      </Link>
      <Link :href="route('mahasiswa')" class="inline-block px-2 py-3 ">
      <div :class="checkUrl('/mahasiswa')"> Mahasiswa Magang </div>
      </Link>
      <Link :href="route('pendaftaran')" class="inline-block px-2 py-3">
      <div :class="checkUrl('/pendaftaran')"> Pendaftaran </div>
      </Link>
    </div>
    <div id="cta_button" class="flex flex-row gap-4 items-center">
      <Link :href="route('login')" class="inline-block px-2 py-3 ">
      Log In
      </Link>
      <Link :href="route('register')" class="inline-block px-2 py-3 ">
      Register
      </Link>
    </div>
  </nav>
</template>