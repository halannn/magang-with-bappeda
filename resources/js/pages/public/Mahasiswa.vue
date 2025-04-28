<script setup lang="ts">
import NavBar from '@/components/NavBar.vue';
import TestimonialCard from '@/components/TestimonialCard.vue';
import TextContainer from '@/components/TextContainer.vue';
import { Head } from '@inertiajs/vue3';

const testimonials = [
  {
    image: 'testimonial_placeholder.jpg',
    nama: 'Reza',
    kampus: 'Universitas Mulawarman',
    bodyText: 'Saya seorang mahasiswa yang tertarik dengan perencanaan pembangunan dan ingin berkontribusi dalam kemajuan daerah.',
    sosmed: {
      instagram: 'https://instagram.com/reza',
      linkedin: 'https://linkedin.com/in/reza',
    },
  },
  {
    image: 'testimonial_placeholder.jpg',
    nama: 'Nadya',
    kampus: 'Politeknik Negeri Balikpapan',
    bodyText: 'Saya passionate di bidang teknologi dan pengembangan diri, serta senang bekerja dalam tim untuk mencapai tujuan bersama.',
    sosmed: {
      instagram: 'https://instagram.com/nadya',
      linkedin: 'https://linkedin.com/in/nadya',
    },
  },
  {
    image: 'testimonial_placeholder.jpg',
    nama: 'Bima',
    kampus: 'Universitas Balikpapan',
    bodyText: 'Saya fokus pada pengembangan keterampilan praktis untuk mempersiapkan diri menghadapi tantangan dunia kerja di bidang teknologi.',
    sosmed: {
      instagram: 'https://instagram.com/bima',
      linkedin: 'https://linkedin.com/in/bima',
    },
  },
  {
    image: 'testimonial_placeholder.jpg',
    nama: 'Sarah',
    kampus: 'Institut Teknologi Kalimantan',
    bodyText: 'Saya percaya bahwa pengalaman magang memberi peluang untuk belajar lebih banyak tentang industri dan membangun jaringan profesional.',
    sosmed: {
      instagram: 'https://instagram.com/sarah',
      linkedin: 'https://linkedin.com/in/sarah',
    },
  },
];


</script>

<template>
  <Head title="Mahasiswa Magang">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <NavBar />

  <main id="content" class="flex flex-col gap-10 bg-gray-50 px-20 py-20">
    <TextContainer
      class="text-center"
      caption="Para Mahasiswa"
      title="Mari Berkenalan dengan Mahasiswa Keren <br/> yang Tumbuh di BAPPEDA"
      :button="false"
    />
    <div id="content" class="flex flex-row justify-between gap-20">
      <TestimonialCard :testimonial="testimonials" />
    </div>
  </main>
</template>
