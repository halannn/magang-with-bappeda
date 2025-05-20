<script setup lang="ts">
import { Auth } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLogo from './AppLogo.vue';
import Button from './ui/button/Button.vue';

const page = usePage<{ auth: Auth }>();
const user = page.props.auth?.user;

const menuOpen = ref(false);

const checkUrl = ref((url: string) => {
    if (page.url === url) {
        return 'border-b-2 border-b-primary';
    }
});
</script>

<template>
    <nav
        class="border-background bg-background fixed top-0 right-0 left-0 z-50 flex items-center justify-between gap-10 border-b-2 p-4 sm:px-10 lg:px-20"
    >
        <div class="flex flex-row items-center gap-2">
            <AppLogo />
        </div>

        <!-- mobile -->
        <button @click="menuOpen = !menuOpen" class="lg:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div
            v-if="menuOpen"
            class="border-background bg-background fixed top-18 right-0 left-0 z-40 flex h-full flex-col gap-10 border-b-2 px-6 py-2 sm:px-10 md:px-10 lg:hidden"
        >
            <div class="flex flex-col items-start gap-2">
                <Link :href="route('home')" class="mt-2 py-2"><div :class="checkUrl('/')">Beranda</div></Link>
                <Link :href="route('tentang')" class="py-2"><div :class="checkUrl('/tentang')">Tentang</div></Link>
                <Link :href="route('mahasiswa')" class="py-2"><div :class="checkUrl('/mahasiswa')">Mahasiswa</div></Link>
                <Link :href="route('pendaftaran')" class="py-2"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
            </div>

            <div class="flex flex-row gap-4">
                <div v-if="user" class="w-full">
                    <Link v-if="user.status === 'admin'" :href="route('admin.dashboard.index')">
                        <Button variant="secondary" class="w-full"> Dashboard </Button>
                    </Link>

                    <Link v-else :href="route('dashboard.index')">
                        <Button variant="secondary" class="w-full"> Dashboard </Button>
                    </Link>
                </div>

                <div v-else class="w-full flex flex-col gap-4">
                    <Button variant="secondary" class="w-full">
                        <Link :href="route('login')">Login</Link>
                    </Button>
                    <Button variant="default" class="w-full">
                        <Link :href="route('register')">Daftar</Link>
                    </Button>
                </div>
            </div>
        </div>

        <!-- Dekstop -->
        <div class="hidden flex-1 gap-4 lg:flex">
            <Link :href="route('home')" class="px-2 py-3"><div :class="checkUrl('/')">Beranda</div></Link>
            <Link :href="route('tentang')" class="px-2 py-3"><div :class="checkUrl('/tentang')">Tentang</div></Link>
            <Link :href="route('mahasiswa')" class="px-2 py-3"><div :class="checkUrl('/mahasiswa')">Mahasiswa</div></Link>
            <Link :href="route('pendaftaran')" class="px-2 py-3"><div :class="checkUrl('/pendaftaran')">Pendaftaran</div></Link>
        </div>

        <div class="hidden flex-row gap-4 lg:flex">
            <div v-if="user">
                <Link v-if="user.status === 'admin'" :href="route('admin.dashboard.index')">
                    <Button variant="default"> Dashboard </Button>
                </Link>

                <Link v-else :href="route('dashboard.index')">
                    <Button variant="default"> Dashboard </Button>
                </Link>
            </div>

            <div v-else class="flex flex-row gap-4">
                <Button variant="secondary">
                    <Link :href="route('login')">Login</Link>
                </Button>
                <Button variant="default">
                    <Link :href="route('register')">Daftar</Link>
                </Button>
            </div>
        </div>
    </nav>
</template>
