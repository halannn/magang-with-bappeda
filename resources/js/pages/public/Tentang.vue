<script setup lang="ts">
import FeatureCard from '@/components/FeatureCard.vue';
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import TextContainer from '@/components/TextContainer.vue';
import TimelineCard from '@/components/TimelineCard.vue';
import { Head } from '@inertiajs/vue3';
import { Brush, CheckCircle2, ClipboardList, Code2, Database, FilePenLine, FileSliders, Newspaper, ShieldCheck, UploadCloud } from 'lucide-vue-next';

const contents = [
  { icon: Newspaper, title: 'Requirements', description: 'Mengumpulkan dan mendefinisikan kebutuhan sistem dari pengguna secara lengkap di awal.' },
  { icon: Brush, title: 'Desain', description: 'Merancang struktur sistem dan antarmuka berdasarkan kebutuhan yang telah ditentukan.' },
  { icon: Code2, title: 'Implementation', description: 'Membangun dan mengembangkan sistem sesuai rancangan yang sudah dibuat.' },
  {
    icon: ShieldCheck,
    title: 'Verification',
    description: 'Menguji sistem untuk memastikan bahwa semua fungsi berjalan sesuai dengan kebutuhan.',
  },
  {
    icon: Database,
    title: 'Requirements',
    description: 'Memperbaiki bug dan melakukan pembaruan agar sistem tetap berjalan optimal setelah digunakan.',
  },
];
</script>

<template>
  <Head title="Tentang">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <NavBar />

  <div id="hero_section" class="bg-opacity-50 relative bg-[url(/why_section.jpg)] bg-cover bg-center">
    <div class="top-0% absolute inset-0 bg-gradient-to-r from-blue-900 from-50% to-blue-50 mix-blend-multiply"></div>
    <div class="relative flex flex-row justify-between px-20">
      <div id="hero_left" class="flex w-full flex-col justify-center gap-10">
        <div id="text" class="flex flex-col gap-6 pr-10 text-gray-50">
          <p class="text-4xl font-bold">Tentang Magang with BAPPEDA</p>
          <p class="text-lg">
            Sistem ini dibangun untuk memberikan kemudahan bagi mahasiswa dalam mengikuti program magang di BAPPEDA, mulai dari pendaftaran hingga
            penerbitan sertifikat. Sistem ini dikembangkan sebagai respons atas proses magang yang sebelumnya masih dilakukan secara manual.
          </p>
        </div>
      </div>
      <div id="hero_right" class="w-full">
        <img src="/potrait.png" alt="" />
      </div>
    </div>
  </div>

  <div id="why_us" class="flex flex-col gap-20 bg-gray-50 px-20 py-20">
    <div id="head" class="flex flex-col gap-5 text-gray-900">
      <p class="text-center text-xl font-bold text-blue-900">Dibangun untuk Kemudahan & Efisiensi</p>
      <p class="text-center text-4xl font-bold">
        Mengubah Magang Biasa <br />
        Menuju Pengalaman Digital
      </p>
    </div>
    <div id="content" class="flex flex-row justify-between gap-20">
      <FeatureCard
        :icon="FilePenLine"
        costumStyle="flex flex-col items-center gap-4 text-center"
        description="Proses pendaftaran magang 100% online melalui formulir digital."
      />
      <FeatureCard
        :icon="CheckCircle2"
        costumStyle="flex flex-col items-center gap-4 text-center"
        description="Catat kehadiran magang langsung via platform dengan sekali klik."
      />
      <FeatureCard
        :icon="ClipboardList"
        costumStyle="flex flex-col items-center gap-4 text-center"
        description="Rekam kegiatan magang harian melalui template laporan."
      />
      <FeatureCard
        :icon="UploadCloud"
        costumStyle="flex flex-col items-center gap-4 text-center"
        description="Upload dokumen pendukung penting ke dalam sistem."
      />
    </div>
  </div>

  <div id="visi" class="flex flex-row gap-20 bg-gray-50 px-20 py-20">
    <div id="head" class="flex w-1/3 flex-col gap-5 text-gray-900">
      <!-- <p class="text-center text-xl font-bold text-blue-900">Dibangun untuk Kemudahan & Efisiensi</p> -->
      <p class="text-4xl font-bold">Visi Kami</p>
      <p>Menjadi platform digital magang terpercaya yang mendukung pengembangan potensi generasi muda di bidang perencanaan pembangunan daerah.</p>
    </div>
    <div id="content" class="flex w-full flex-row gap-20">
      <FeatureCard
        :icon="FileSliders"
        costumStyle=" flex flex-col gap-4"
        title="Proses Magang"
        description="Sistem yang mempermudah mahasiswa selama  masa magang mereka berlangsung"
      />
      <FeatureCard
        :icon="CheckCircle2"
        costumStyle=" flex flex-col gap-4"
        title="Monitoring yang Transparan"
        description="Kemudahan bagi admin BAPPEDA untuk memantau kegiatan magang"
      />
      <FeatureCard
        :icon="ClipboardList"
        costumStyle=" flex flex-col gap-4"
        title="Inovasi Digital di Instansi Pemerintah"
        description="Solusi teknologi sebagai langkah awal transformasi digital dalam  magang di pemerintahan."
      />
    </div>
  </div>

  <div id="timeline_sistem" class="flex flex-col gap-20 bg-gray-50 px-20 py-20">
    <TextContainer
      class=""
      caption="Perjananan pengembangan sistem"
      title="Dari konsep hingga siap diguanakan"
      description="Sistem Magang with BAPPEDA dikembangkan secara bertahap dengan pendekatan metodologi Waterfall, yang memastikan setiap fase dirancang dengan matang sebelum melangkah ke tahap berikutnya. Proses ini melibatkan analisis kebutuhan, perancangan sistem, pengembangan fitur, pengujian, hingga tahap akhir berupa perbaikan dan publikasi."
      :button="false"
    />
    <TimelineCard :contents="contents" />
  </div>

  <Footer />
</template>
