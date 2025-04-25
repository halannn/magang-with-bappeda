<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';
</script>

<template>

  <Head title="Beranda">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <NavBar />
  <Footer/>
</template>