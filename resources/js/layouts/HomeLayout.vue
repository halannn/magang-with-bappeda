<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
</script>

<template>
    <NavBar />
    <slot />
    <Footer />
</template>
