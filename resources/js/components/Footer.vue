<script setup lang="ts">
import { Clock, Github, Instagram, Linkedin, Mail, MapPin, Phone } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
</script>

<template>
    <footer class="bg-background flex w-full flex-col gap-4 p-4 md:gap-10 md:p-10 lg:gap-20 lg:p-20">
        <div class="flex flex-col gap-4 md:flex-row md:gap-10 lg:gap-20">
            <div class="flex basis-1/5 flex-col gap-4">
                <div class="flex flex-row items-center gap-2">
                    <AppLogo />
                </div>
                <p class="text-sm whitespace-pre-line lg:text-base">
                    Platform resmi pendaftaran dan manajemen magang BAPPEDA Litbang Kota Balikpapan.
                </p>
            </div>

            <div class="flex basis-1/5 flex-col gap-4">
                <h5 class="font-bold">Navigasi</h5>
                <div class="flex flex-row justify-between gap-2 text-sm md:flex-col lg:text-base">
                    <a :href="route('home')" class="hover:underline">Beranda</a>
                    <a :href="route('tentang')" class="hover:underline">Tentang</a>
                    <a :href="route('mahasiswa')" class="hover:underline">Mahasiswa</a>
                    <a :href="route('pendaftaran')" class="hover:underline">Pendaftaran</a>
                </div>
            </div>

            <div class="flex basis-2/5 flex-col gap-4">
                <h5 class="font-bold">Informasi</h5>
                <div class="flex flex-col gap-4 text-sm lg:text-base">
                    <div class="flex flex-row items-center gap-2">
                        <MapPin />
                        <p>Alamat: Kantor BAPPEDA Litbang Balikpapan</p>
                    </div>
                    <div class="flex flex-row items-center gap-2">
                        <Phone />
                        <p>Telepon: (0542) 123456</p>
                    </div>
                    <div class="flex flex-row items-center gap-2">
                        <Mail />
                        <p>Email: magangwithbappeda@gmail.com</p>
                    </div>
                    <div class="flex flex-row items-center gap-2">
                        <Clock />
                        <p>Operasional: Senin–Jumat, 08.00–16.00 WITA</p>
                    </div>
                </div>
            </div>

            <div class="mb-4 flex basis-1/5 flex-col gap-4">
                <h5 class="font-bold">Sosial</h5>
                <div class="flex flex-row gap-4">
                    <Instagram />
                    <Linkedin />
                    <Github />
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <div class="border-t-foreground bg-foreground p-0.5"></div>
            <div class="flex justify-center text-sm font-bold">&copy; 2025 Magang with BAPPEDA.</div>
        </div>
    </footer>
</template>
