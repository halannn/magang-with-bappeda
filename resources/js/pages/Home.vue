<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';
import Button from '@/components/ui/button/Button.vue';
import { ArrowRight, FilePenLine, FileCheck, Building2, Waypoints, Users, University, Calendar, CheckCircle2 } from 'lucide-vue-next';
import ShortFAQ from '@/components/ui/ShortFAQ.vue';

</script>

<template>

  <Head title="Beranda">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <NavBar />

  <div id="hero_section" class="flex flex-row px-20 py-10 justify-between">
    <div id="hero_left" class="flex flex-col gap-10 w-full justify-center ">
      <div id="text" class="flex flex-col gap-6 pr-10">
        <p class="text-xl font-bold text-blue-900">
          Tingkatkan Pengalaman, Bangun Masa Depan!
        </p>
        <p class="text-4xl font-bold">
          Magang Bersama BAPPEDA – Langkah Awal Menuju Karier Gemilang
        </p>
        <p class="text-lg">
          Program ini dirancang untuk mengasah kemampuan, memperluas jaringan, dan membuka pintu menuju karier masa
          depan yang cemerlang. Jangan lewatkan kesempatan untuk belajar langsung dari para ahli di bidang perencanaan
          pembangunan!
        </p>
      </div>
      <div id="cta" class="">
        <Button size="lg" class="bg-blue-900 text-gray-50 font-medium hover:bg-gray-900">
          Daftar Magang Sekarang
          <ArrowRight />
        </Button>
      </div>
    </div>
    <div id="hero_right" class="w-full ">
      <img src="/Hero_Image.png" alt="" class="">
    </div>
  </div>

  <div id="why_us" class="flex flex-col gap-20 px-20 py-20 bg-gray-900">
    <div id="head" class="flex flex-col gap-5 text-gray-50">
      <p class="text-4xl font-bold text-center">
        Mengapa Magang di BAPPEDA?
      </p>
      <p class="text-lg text-center">
        Program ini dirancang untuk mengasah kemampuan, memperluas jaringan, dan membuka pintu menuju karier masa depan
        yang cemerlang.
        Jangan lewatkan kesempatan untuk belajar langsung dari para ahli di bidang perencanaan pembangunan!
      </p>
    </div>
    <div id="content" class="flex flex-row gap-20">
      <div id="left" class="flex flex-col gap-5 w-full">
        <div id="mini_card" class="flex flex-row items-center px-5 py-5 gap-5 bg-gray-50 rounded-2xl">
          <FilePenLine :size="48" class="" />
          <div id="text" class="">
            <h1 class="text-lg font-bold">
              Belajar dari Praktisi Pemerintah Daerah
            </h1>
            <p class="">
              Dapatkan wawasan langsung dari profesional di bidang perencanaan pembangunan daerah.
            </p>
          </div>
        </div>
        <div id="mini_card" class="flex flex-row items-center px-5 py-5 gap-5 bg-gray-50 rounded-2xl">
          <Waypoints :size="48" class="" />
          <div id="text" class="">
            <h1 class="text-lg font-bold">
              Perluas Relasi Profesional
            </h1>
            <p class="">
              Bangun jaringan dengan ASN, akademisi, dan mitra pembangunan kota.
            </p>
          </div>
        </div>
        <div id="mini_card" class="flex flex-row items-center px-5 py-5 gap-5 bg-gray-50 rounded-2xl">
          <Building2 :size="48" class="" />
          <div id="text" class="">
            <h1 class="text-lg font-bold">
              Kontribusi Nyata untuk Daerah
            </h1>
            <p class="">
              Berpartisipasi dalam kegiatan yang berdampak langsung terhadap perencanaan kota Balikpapan.
            </p>
          </div>
        </div>
        <div id="mini_card" class="flex flex-row items-center px-5 py-5 gap-5 bg-gray-50 rounded-2xl">
          <FileCheck :size="48" class="" />
          <div id="text" class="">
            <h1 class="text-lg font-bold">
              Sertifikat dan Portofolio
            </h1>
            <p class="">
              Dapatkan sertifikat resmi dan hasil kerja yang dapat digunakan untuk portofolio kariermu.
            </p>
          </div>
        </div>
      </div>h
      <div id="right" class="shadow-2xl w-full">
        <img src="/why_section.jpg" alt="" class="rounded-2xl h-full object-cover">
      </div>
    </div>
  </div>

  <div id="testimonials" class="flex flex-col gap-20 px-20 py-20 bg-gray-50">
    <div id="head" class="flex flex-col gap-5">
      <p class="text-4xl font-bold text-center">
        Apa Kata Mereka Tentang Magang di BAPPEDA?
      </p>
      <p class="text-lg text-center">
        Kami percaya bahwa pengalaman terbaik datang dari proses yang nyata.
        Berikut kisah dan kesan para mahasiswa yang telah tumbuh bersama BAPPEDA.
      </p>
    </div>
    <div id="content" class="flex flex-row gap-20 justify-between">
      <div id="card_testimonial" class="w-full flex flex-col shadow p-4 rounded-2xl gap-5">
        <div id="head" class="w-full">
          <img src="testimonial_placeholder.jpg" alt="" class="w-full h-60 rounded-2xl object-cover">
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              Reza
            </p>
            <p class="font-medium text-gray-500">
              Universitas Mulawarman
            </p>
          </div>
          <p id="content" class="">
            Magang di BAPPEDA sangat membuka wawasan saya tentang proses perencanaan pembangunan daerah.
          </p>
        </div>
      </div>
      <div id="card_testimonial" class="w-full flex flex-col shadow p-4 rounded-2xl gap-5">
        <div id="head" class="w-full">
          <img src="testimonial_placeholder.jpg" alt="" class="w-full h-60 rounded-2xl object-cover">
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              Nadya
            </p>
            <p class="font-medium text-gray-500">
              Politeknik Negeri Balikpapan
            </p>
          </div>
          <p id="content" class="">
            Saya belajar tidak hanya secara teknis, tapi juga bagaimana bekerja sama dalam tim profesional.
          </p>
        </div>
      </div>
      <div id="card_testimonial" class="w-full flex flex-col shadow p-4 rounded-2xl gap-5">
        <div id="head" class="w-full">
          <img src="testimonial_placeholder.jpg" alt="" class="w-full h-60 rounded-2xl object-cover">
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              Bima
            </p>
            <p class="font-medium text-gray-500">
              Universitas Balikpapan
            </p>
          </div>
          <p id="content" class="">
            Pengalaman magang ini sangat membantu saya dalam menyusun skripsi dan mempersiapkan dunia kerja.
          </p>
        </div>
      </div>
      <div id="card_testimonial" class="w-full flex flex-col shadow p-4 rounded-2xl gap-5">
        <div id="head" class="w-full">
          <img src="testimonial_placeholder.jpg" alt="" class="w-full h-60 rounded-2xl object-cover">
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              Sarah
            </p>
            <p class="font-medium text-gray-500">
              Institut Teknologi Kalimantan
            </p>
          </div>
          <p id="content" class="">
            Pengalaman magang di sini membuat saya lebih siap menghadapi dunia kerja. Banyak pelajaran berharga yang
            saya dapatkan.
          </p>
        </div>
      </div>

    </div>
  </div>

  <div id="highlight" class="flex flex-col gap-12 px-20 py-12 justify-center">
    <p class="font-bold text-4xl text-center">Dibangun untuk Masa Depan</p>
    <p class="text-center">Sejak diluncurkan, program magang BAPPEDA telah menjadi wadah pengembangan diri bagi
      mahasiswa dari
      berbagai perguruan tinggi.
    </p>
    <div id="cards" class="flex flex-row gap-6">
      <div id="card" class="w-full flex flex-row shadow p-4 rounded-2xl gap-5">
        <div id="head" class="flex items-center">
          <Users :size="40" />
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              25+
            </p>
            <p class="font-medium text-gray-500">
              Mahasiswa magang
            </p>
          </div>
        </div>
      </div>
      <div id="card" class="w-full flex flex-row shadow p-4 rounded-2xl gap-5">
        <div id="head" class="flex items-center">
          <University :size="40" />
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              4+
            </p>
            <p class="font-medium text-gray-500">
              Kampus Bergabung
            </p>
          </div>
        </div>
      </div>
      <div id="card" class="w-full flex flex-row shadow p-4 rounded-2xl gap-5">
        <div id="head" class="flex items-center">
          <Calendar :size="40" />
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              3+
            </p>
            <p class="font-medium text-gray-500">
              Tahun program berjalan
            </p>
          </div>
        </div>
      </div>
      <div id="card" class="w-full flex flex-row shadow p-4 rounded-2xl gap-5">
        <div id="head" class="flex items-center">
          <CheckCircle2 :size="40" />
        </div>
        <div id="body" class="flex flex-col gap-3">
          <div id="title" class="">
            <p class="text-xl font-bold">
              25+
            </p>
            <p class="font-medium text-gray-500">
              Mahasiswa magang
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="short_faq" class="flex flex-col gap-20 px-20 py-20 bg-gray-800">
    <div id="head" class="flex flex-col gap-5 text-gray-50 ">
      <p class="text-xl font-medium text-center">
        Pertanyaan yang Sering Ditanyakan
      </p>
      <p class="text-4xl font-bold text-center whitespace-normal">
        Temukan jawaban atas pertanyaan umum <br />
        seputar program magang di sini.
      </p>
    </div>

    <ShortFAQ />

  </div>
  
  <Footer />
</template>