<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import TextContainer from '@/components/TextContainer.vue';
import TimelineCard from '@/components/TimelineCard.vue';
import ShortFAQ from '@/components/ui/ShortFAQ.vue';
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
  <Head title="Pendaftaran">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <NavBar />

  <div id="timeline_pendaftaram" class="flex flex-col gap-20 bg-gray-50 px-20 py-20">
    <TextContainer
      class=""
      caption="Siap Bergabung? Wujudkan Langkah Awal Menuju Karier Impianmu."
      title="Pendaftaran Magang yang Mudah, Cepat, dan Terstruktur"
      description="Proses pendaftaran dirancang agar kamu bisa fokus pada yang penting: bersiap untuk berkembang.
Cukup ikuti langkah-langkahnya, dan kami akan bantu mengarahkanmu sampai siap bergabung."
      :button="false"
    />
    <TimelineCard :contents="contents" />
  </div>

  <div id="short_faq" class="flex flex-col gap-20 bg-gray-800 px-20 py-20">
    <div id="head" class="flex flex-col gap-5 text-gray-50">
      <p class="text-center text-xl font-medium">Pertanyaan yang Sering Ditanyakan</p>
      <p class="text-center text-4xl font-bold whitespace-normal">
        Temukan jawaban atas pertanyaan umum <br />
        seputar program magang di sini.
      </p>
    </div>
    <ShortFAQ />
  </div>

  <Footer />
</template>
