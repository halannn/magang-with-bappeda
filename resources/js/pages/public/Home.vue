<script setup lang="ts">
import FeatureCard from '@/components/FeatureCard.vue';
import ShortFAQ from '@/components/ShortFAQ.vue';
import TextContainer from '@/components/TextContainer.vue';
import HomeLayout from '@/layouts/HomeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { AwardIcon, BookOpenCheckIcon, Building2Icon, Calendar, CheckCircle2, FileCheckIcon, University, Users } from 'lucide-vue-next';

const testimonials = [
    {
        image: 'testimonial_placeholder.jpg',
        nama: 'Reza',
        kampus: 'Universitas Mulawarman',
        bodyText: 'Magang di BAPPEDA sangat membuka wawasan saya tentang proses perencanaan pembangunan daerah.',
        sosmed: {
            instagram: 'https://instagram.com/reza',
            linkedin: 'https://linkedin.com/in/reza',
        },
    },
    {
        image: 'testimonial_placeholder.jpg',
        nama: 'Nadya',
        kampus: 'Politeknik Negeri Balikpapan',
        bodyText: 'Saya belajar tidak hanya secara teknis, tapi juga bagaimana bekerja sama dalam tim profesional.',
        sosmed: {
            instagram: 'https://instagram.com/nadya',
            linkedin: 'https://linkedin.com/in/nadya',
        },
    },
    {
        image: 'testimonial_placeholder.jpg',
        nama: 'Bima',
        kampus: 'Universitas Balikpapan',
        bodyText: 'Pengalaman magang ini sangat membantu saya dalam menyusun skripsi dan mempersiapkan dunia kerja.',
        sosmed: {
            instagram: 'https://instagram.com/bima',
            linkedin: 'https://linkedin.com/in/bima',
        },
    },
    {
        image: 'testimonial_placeholder.jpg',
        nama: 'Sarah',
        kampus: 'Institut Teknologi Kalimantan',
        bodyText: 'Pengalaman magang di sini membuat saya lebih siap menghadapi dunia kerja. Banyak pelajaran berharga yang saya dapatkan.',
        sosmed: {
            instagram: 'https://instagram.com/sarah',
            linkedin: 'https://linkedin.com/in/sarah',
        },
    },
];
</script>

<template>
    <Head title="Beranda" />
    <HomeLayout>
        <main class="mt-18 flex flex-col">
            <div
                id="hero_section"
                class="bg-background flex flex-col-reverse justify-between gap-4 px-4 py-10 md:gap-10 md:px-10 lg:flex-row lg:gap-20 lg:px-20 lg:py-20"
            >
                <TextContainer
                    caption="Tingkatkan Pengalaman, Bangun Masa Depan!"
                    title="Magang Bersama Bappeda Litbang - Langkah Awal Menuju Karier Gemilang"
                    description="Program ini dirancang untuk mengasah kemampuan, memperluas jaringan, dan membuka pintu menuju karier masa depan yang cemerlang. Jangan lewatkan kesempatan untuk belajar langsung dari para ahli di bidang perencanaan pembangunan!"
                    :button="true"
                    buttonText="Daftar Magang Sekarang"
                    buttonLink="pendaftaran"
                />
                <div id="hero_right" class="flex w-full justify-center">
                    <img src="/Hero_Image.svg" alt="" class="lg:w-full" />
                </div>
            </div>

            <div id="why_us" class="bg-muted flex flex-col justify-between gap-4 px-4 py-10 md:gap-10 md:px-10 lg:gap-20 lg:px-20">
                <TextContainer
                    class="text-center"
                    title="Mengapa Magang Di Bappeda Litbang?"
                    description="Program ini dirancang untuk mengasah kemampuan, memperluas jaringan, dan membuka pintu menuju karier masa depan yang cemerlang. <br/>Jangan lewatkan kesempatan untuk belajar langsung dari para ahli di bidang perencanaan pembangunan!"
                    :button="false"
                />
                <div id="content" class="flex flex-col-reverse gap-4 md:gap-10 lg:flex-row lg:gap-20">
                    <div id="left" class="flex w-full flex-col gap-5">
                        <FeatureCard
                            :icon="FileCheckIcon"
                            title="Belajar dari Praktisi Pemerintah Daerah"
                            description="Dapatkan wawasan langsung dari profesional di bidang perencanaan pembangunan daerah."
                        />
                        <FeatureCard
                            :icon="BookOpenCheckIcon"
                            title="Perluas Relasi Profesional"
                            description="Bangun jaringan dengan ASN, akademisi, dan mitra pembangunan kota."
                        />
                        <FeatureCard
                            :icon="Building2Icon"
                            title="Kontribusi Nyata untuk Daerah"
                            description="Berpartisipasi dalam kegiatan yang berdampak langsung terhadap perencanaan kota Balikpapan."
                        />
                        <FeatureCard
                            :icon="AwardIcon"
                            title="Sertifikat dan Portofolio"
                            description="Dapatkan sertifikat resmi dan hasil kerja yang dapat digunakan untuk portofolio kariermu."
                        />
                    </div>
                    <div id="right" class="w-full shadow-2xl">
                        <img src="/why_section.jpg" alt="" class="h-full rounded-2xl object-cover" />
                    </div>
                </div>
            </div>

            <!-- <div id="testimonials" class="bg-background flex flex-col justify-between gap-4 px-4 py-10 md:px-10 lg:flex-col lg:px-20">
                <div id="head" class="flex flex-col gap-4">
                    <TextContainer
                        class="text-center"
                        title="Apa Kata Mereka Tentang Magang Di Bappeda Litbang?"
                        description="Kami percaya bahwa pengalaman terbaik datang dari proses yang nyata. Berikut kisah dan kesan para mahasiswa yang telah tumbuh bersama BAPPEDA."
                        :button="false"
                    />
                </div>
                <TestimonialCard :testimonial="testimonials" />
            </div> -->

            <div id="highlight" class="bg-background flex flex-col justify-between gap-4 px-4 py-10 md:gap-10 md:px-10 lg:flex-col lg:px-20 lg:py-20">
                <div id="head" class="flex flex-col gap-4">
                    <p class="text-center text-2xl font-bold">Dibangun untuk masa depan</p>
                    <p class="text-center">
                        Sejak diluncurkan, program magang BAPPEDA telah menjadi wadah pengembangan diri bagi mahasiswa dari berbagai perguruan tinggi.
                    </p>
                </div>
                <div id="cards" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <FeatureCard
                        :icon="Users"
                        costumStyle="flex w-full flex-row gap-5 rounded-2xl p-4 shadow items-center"
                        title="25+"
                        description="Mahasiswa magang"
                    />
                    <FeatureCard
                        :icon="University"
                        costumStyle="flex w-full flex-row gap-5 rounded-2xl p-4 shadow items-center"
                        title="4+"
                        description="Kampus Bergabung"
                    />
                    <FeatureCard
                        :icon="Calendar"
                        costumStyle="flex w-full flex-row gap-5 rounded-2xl p-4 shadow items-center"
                        title="3+"
                        description="Tahun program berjalan"
                    />
                    <FeatureCard
                        :icon="CheckCircle2"
                        costumStyle="flex w-full flex-row gap-5 rounded-2xl p-4 shadow items-center"
                        title="100%"
                        description="Menerima sertifikat"
                    />
                </div>
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
