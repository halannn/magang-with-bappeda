<script setup lang="ts">
import ShortFAQ from '@/components/ShortFAQ.vue';
import TextContainer from '@/components/TextContainer.vue';
import TimelineCard from '@/components/TimelineCard.vue';
import HomeLayout from '@/layouts/HomeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { BookCheck, ClipboardList, Newspaper, ShieldCheck, UserRoundCheck } from 'lucide-vue-next';

const contents = [
    {
        icon: Newspaper,
        title: 'Isi Formulir Pendaftaran',
        description: 'Buat akun, lengkapi data diri, asal kampus, dan unggah dokumen persyaratan melalui formulir online.',
    },
    {
        icon: ShieldCheck,
        title: 'Verifikasi oleh Admin',
        description: 'Tim admin akan mengecek kelengkapan dan keaslian data serta dokumen yang kamu kirimkan.',
    },
    {
        icon: UserRoundCheck,
        title: 'Konfirmasi & Akses Akun',
        description: 'Jika lolos verifikasi, kamu akan mendapat konfirmasi dan dapat login ke dashboard pribadi.',
    },
    {
        icon: ClipboardList,
        title: 'Mulai Magang & Lapor Harian',
        description: 'Laksanakan magang sesuai penempatan. Gunakan dashboard untuk absen dan mengisi laporan harian.',
    },
    {
        icon: BookCheck,
        title: 'Selesaikan Magang',
        description: 'Unggah dokumen akhir, berikan ulasan, dan unduh sertifikat resmi sebagai bukti partisipasi.',
    },
];
</script>

<template>
    <Head title="Pendaftaran" />
    <HomeLayout>
        <main class="mt-18 flex flex-col">
            <div id="timeline_pendaftaram" class="bg-background flex flex-col justify-between gap-4 px-4 py-10 md:px-10 lg:px-20">
                <TextContainer
                    caption="Siap Bergabung? Wujudkan Langkah Awal Menuju Karier Impianmu."
                    title="Pendaftaran Magang yang Mudah, Cepat, dan Terstruktur"
                    description="Proses pendaftaran dirancang agar kamu bisa fokus pada yang penting: bersiap untuk berkembang.
        Cukup ikuti langkah-langkahnya, dan kami akan bantu mengarahkanmu sampai siap bergabung."
                    :button="true"
                    buttonLink="pendaftaran/form-profile"
                    button-text="Daftar"
                />
                <TimelineCard :contents="contents" class="mt-10" />
            </div>

            <div id="short_faq" class="bg-muted flex flex-col justify-between gap-4 px-4 py-10 md:px-10 lg:px-20">
                <div id="head" class="flex flex-col gap-5">
                    <p class="text-center font-medium">Pertanyaan yang Sering Ditanyakan</p>
                    <p class="text-center text-2xl font-bold whitespace-normal">Temukan jawaban atas pertanyaan umum seputar program magang.</p>
                </div>
                <ShortFAQ />
            </div>
        </main>
    </HomeLayout>
</template>
