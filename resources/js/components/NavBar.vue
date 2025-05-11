<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from './ui/button/Button.vue';

const page = usePage();
const menuOpen = ref(false);

const checkUrl = ref((url: string) => {
    if (page.url === url) {
        return 'border-b-3 border-b-primary';
    }
});
</script>

<template>
    <!-- <nav class="fixed top-0 right-0 left-0 z-10 flex items-center justify-between border-b-2 border-gray-300 bg-gray-50 px-6 py-4 md:px-20">
        
        <div class="flex items-start gap-2">
            <div class="h-10 w-10 bg-blue-900"></div>
            <div class="flex flex-col">
                <p class="text-2xl leading-none">Magang</p>
                <p class="text-xs">with BAPPEDA</p>
            </div>
        </div>

        <button @click="menuOpen = !menuOpen" class="md:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="hidden flex-1 justify-center gap-4 md:flex">
            <Link :href="route('home')" class="px-2 py-3"><div :class="checkUrl('/')">Beranda</div></Link>
            <Link :href="route('tentang')" class="px-2 py-3"><div :class="checkUrl('/tentang')">Tentang</div></Link>
            <Link :href="route('mahasiswa')" class="px-2 py-3"><div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div></Link>
            <Link :href="route('pendaftaran')" class="px-2 py-3"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
        </div>

        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard.index')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
            Dashboard
        </Link>

        <div v-else class="hidden items-center gap-4 md:flex">
            <Button size="lg" class="bg-transparent px-2 py-3 font-medium text-blue-900 outline outline-blue-900 hover:bg-blue-900 hover:text-white">
                <Link :href="route('login')">Login</Link>
            </Button>
            <Button size="lg" class="bg-blue-900 px-2 py-3 font-medium text-white hover:bg-gray-900">
                <Link :href="route('register')">Daftar</Link>
            </Button>
        </div>
    </nav>

    <div v-if="menuOpen" class="fixed top-18 right-0 left-0 z-10 flex h-fit flex-col items-start gap-2 bg-gray-50 px-6 pb-4 md:hidden">
        <Link :href="route('home')" class="py-2"><div :class="checkUrl('/')">Beranda</div></Link>
        <Link :href="route('tentang')" class="py-2"><div :class="checkUrl('/tentang')">Tentang</div></Link>
        <Link :href="route('mahasiswa')" class="py-2"><div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div></Link>
        <Link :href="route('pendaftaran')" class="py-2"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard.index')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
            Dashboard
        </Link>
        <div v-else class="mt-10 flex w-full flex-col gap-2">
            <Button class="w-full bg-transparent text-blue-900 outline outline-blue-900 hover:bg-blue-900 hover:text-white">
                <Link :href="route('login')">Login</Link>
            </Button>
            <Button class="w-full bg-blue-900 text-white hover:bg-gray-900">
                <Link :href="route('register')">Daftar</Link>
            </Button>
        </div>
    </div> -->

    <nav class="fixed top-0 right-0 left-0 z-50 flex items-center justify-between border-b-2 border-gray-300 bg-gray-50 px-4 py-4 md:px-20">
        <div class="flex flex-row items-start gap-2">
            <div class="bg-primary h-10 w-10"></div>
            <div class="flex flex-col">
                <p class="text-2xl leading-none">Magang</p>
                <p class="text-xs">with BAPPEDA</p>
            </div>
        </div>

        <button @click="menuOpen = !menuOpen" class="md:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div
            v-if="menuOpen"
            class="fixed top-18 right-0 left-0 z-50 flex h-full flex-col gap-10 border-b-2 border-gray-300 bg-gray-50 px-6 pb-4 md:hidden"
        >
            <div class="flex flex-col items-start gap-2">
                <Link :href="route('home')" class="mt-2 py-2"><div :class="checkUrl('/')">Beranda</div></Link>
                <Link :href="route('tentang')" class="py-2"><div :class="checkUrl('/tentang')">Tentang</div></Link>
                <Link :href="route('mahasiswa')" class="py-2"><div :class="checkUrl('/mahasiswa')">Mahasiswa Magang</div></Link>
                <Link :href="route('pendaftaran')" class="py-2"><div :class="checkUrl('/pendaftaran')">Pendaftaran Magang</div></Link>
            </div>

            <div class="flex flex-row gap-4">
                <div class="text-center" v-if="$page.props.auth.user">
                    <Link
                        :href="route('pendaftaran.profile.create')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Pendaftaran
                    </Link>
                </div>

                <div v-else class="flex flex-row gap-4">
                    <Button variant="secondary" class="w-full">
                        <Link :href="route('login')">Login</Link>
                    </Button>
                    <Button variant="default" class="w-full">
                        <Link :href="route('register')">Daftar</Link>
                    </Button>
                </div>
            </div>
        </div>
    </nav>
</template>
