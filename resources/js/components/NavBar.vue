<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const menuOpen = ref(false);

const checkUrl = ref((url: string) => {
    if (page.url === url) {
        return 'border-b-3 border-b-blue-900';
    }
});
</script>

<template class="relative">
    <nav class="fixed top-0 right-0 left-0 z-10 flex items-center justify-between border-b-2 border-gray-300 bg-gray-50 px-6 py-4 md:px-20">
        <!-- Logo -->
        <div class="flex items-start gap-2">
            <div class="h-10 w-10 bg-blue-900"></div>
            <div class="flex flex-col">
                <p class="text-2xl leading-none">Magang</p>
                <p class="text-xs">with BAPPEDA</p>
            </div>
        </div>

        <!-- Hamburger Button -->
        <button @click="menuOpen = !menuOpen" class="md:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Navigation Links (Desktop) -->
        <div class="hidden flex-1 justify-center gap-4 md:flex">
            <Link :href="route('home')" class="px-2 py-3"><div :class="checkUrl('/')">Beranda</div></Link>
            <Link :href="route('tentang')" class="px-2 py-3"><div :class="checkUrl('/tentang')">Tentang</div></Link>
            <Link :href="route('mahasiswa')" class="px-2 py-3"><div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div></Link>
            <Link :href="route('pendaftaran')" class="px-2 py-3"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
        </div>

        <!-- CTA Buttons (Desktop) -->
        <div class="hidden items-center gap-4 md:flex">
            <Button size="lg" class="bg-transparent px-2 py-3 font-medium text-blue-900 outline outline-blue-900 hover:bg-blue-900 hover:text-white">
                <Link :href="route('login')">Login</Link>
            </Button>
            <Button size="lg" class="bg-blue-900 px-2 py-3 font-medium text-white hover:bg-gray-900">
                <Link :href="route('register')">Daftar</Link>
            </Button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div v-if="menuOpen" class="fixed top-18 right-0 left-0 z-10 flex h-fit flex-col items-start gap-2 bg-gray-50 px-6 pb-4 md:hidden">
        <Link :href="route('home')" class="py-2"><div :class="checkUrl('/')">Beranda</div></Link>
        <Link :href="route('tentang')" class="py-2"><div :class="checkUrl('/tentang')">Tentang</div></Link>
        <Link :href="route('mahasiswa')" class="py-2"><div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div></Link>
        <Link :href="route('pendaftaran')" class="py-2"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
        <div class="mt-10 flex w-full flex-col gap-2">
            <Button class="w-full bg-transparent text-blue-900 outline outline-blue-900 hover:bg-blue-900 hover:text-white">
                <Link :href="route('login')">Login</Link>
            </Button>
            <Button class="w-full bg-blue-900 text-white hover:bg-gray-900">
                <Link :href="route('register')">Daftar</Link>
            </Button>
        </div>
    </div>
</template>
