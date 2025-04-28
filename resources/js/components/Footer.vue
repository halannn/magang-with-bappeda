<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Clock, Github, Instagram, Linkedin, Mail, MapPin, PhoneCallIcon } from 'lucide-vue-next';
</script>

<template>
  <footer class="flex flex-col gap-12 bg-blue-900 px-20 py-12 text-gray-50">
    <div id="menu" class="flex flex-row gap-12">
      <div id="menu_1" class="flex w-full flex-col gap-4">
        <div id="logo_container" class="flex flex-row gap-2">
          <div id="logo" class="h-6 w-6 bg-gray-50"></div>
          <div id="text" class="flex flex-col">
            <p class="text-2xl leading-none">Magang</p>
            <p class="text-xs">with BAPPEDA</p>
          </div>
        </div>
        <div id="desc" class="w-full text-sm">Platform resmi pendaftaran dan manajemen magang di BAPPEDA Balikpapan.</div>
      </div>
      <div id="menu_2" class="flex w-full flex-col gap-4">
        <div class="py-3 text-lg font-bold">Navigasi</div>
        <Link :href="route('home')"> Beranda </Link>
        <Link :href="route('tentang')"> Tentang </Link>
        <Link :href="route('mahasiswa')"> Mahasiswa Magang </Link>
        <Link :href="route('pendaftaran')"> Pendaftaran </Link>
      </div>
      <div id="menu_3" class="flex w-fit flex-col gap-4">
        <div class="w-full py-3 text-lg font-bold">Kontak</div>
        <div id="alamat" class="flex flex-row gap-2 whitespace-nowrap">
          <MapPin color="white" />
          Alamat: Kantor BAPPEDA Litbang Balikpapan
        </div>
        <div id="telepon" class="flex flex-row gap-2 whitespace-nowrap">
          <PhoneCallIcon />
          Telepon: (0542) 123456
        </div>
        <div id="email" class="flex flex-row gap-2 whitespace-nowrap">
          <Mail />
          Email: magang@bappedabalikpapan.go.id
        </div>
        <div id="jam" class="flex flex-row gap-2 whitespace-nowrap">
          <Clock />
          Jam Operasional: Senin–Jumat, 08.00–16.00 WITA
        </div>
      </div>
      <div id="menu_4" class="flex flex-col gap-4 whitespace-nowrap">
        <div class="py-3 text-lg font-bold">Join Us</div>
        <div class="flex flex-row gap-2">
          <Instagram />
          <Linkedin />
          <Github />
        </div>
      </div>
    </div>

    <div id="separator" class="w-full border-b-2 border-b-gray-300"></div>

    <div class="w-full text-center text-sm">© 2025 Magang with BAPPEDA</div>
  </footer>
</template>
