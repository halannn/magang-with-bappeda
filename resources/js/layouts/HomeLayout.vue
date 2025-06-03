<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import 'vue-sonner/style.css';
import { Toaster } from '@/components/ui/sonner';

</script>

<template>
    <Toaster class="pointer-events-auto !z-[9999]" position="top-center" richColors />
    <NavBar />
    <slot />
    <Footer />
</template>
