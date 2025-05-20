<script setup lang="ts">
import FeatureCard from '@/components/FeatureCard.vue';
import TextContainer from '@/components/TextContainer.vue';
import TimelineCard from '@/components/TimelineCard.vue';
import HomeLayout from '@/layouts/HomeLayout.vue';
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
        title: 'Maintenance',
        description: 'Memperbaiki bug dan melakukan pembaruan agar sistem tetap berjalan optimal setelah digunakan.',
    },
];
</script>

<template>
    <Head title="Tentang" />
    <HomeLayout>
        <main class="mt-18 flex flex-col">
            <div id="hero_section" class="bg-opacity-50 relative bg-cover bg-center md:bg-[url(/why_section.jpg)]">
                <div
                    class="top-0% bg-muted md:from-foreground/90 dark:from-background/90 md:to-background dark:to-foreground absolute inset-0 md:bg-gradient-to-r md:from-50% md:mix-blend-multiply"
                ></div>
                <div class="relative flex flex-row justify-between px-4 md:px-10 lg:px-20">
                    <div id="hero_left" class="flex w-full flex-col justify-center gap-10">
                        <div id="text" class="md:text-background text-foreground dark:text-foreground flex flex-col gap-6 py-10">
                            <p class="text-2xl font-bold">Tentang Magang with BAPPEDA</p>
                            <p class="text-base">
                                Sistem ini dibangun untuk memberikan kemudahan bagi mahasiswa dalam mengikuti program magang di BAPPEDA, mulai dari
                                pendaftaran hingga penerbitan sertifikat. Sistem ini dikembangkan sebagai respons atas proses magang yang sebelumnya
                                masih dilakukan secara manual.
                            </p>
                        </div>
                    </div>
                    <div id="hero_right" class="hidden md:block md:w-full">
                        <img src="/potrait.png" alt="" />
                    </div>
                </div>
            </div>

            <div id="why_us" class="bg-background flex flex-col justify-between gap-4 px-4 py-10 md:px-10 lg:flex-col lg:px-20">
                <div id="head" class="flex flex-col gap-5">
                    <p class="text-center font-bold">Dibangun untuk Kemudahan & Efisiensi</p>
                    <p class="text-center text-2xl font-bold">
                        Mengubah magang biasa <br />
                        Menuju pengalaman digital
                    </p>
                </div>
                <div id="content" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <FeatureCard
                        :icon="FilePenLine"
                        costumStyle="flex w-full flex-row  gap-5 rounded-2xl p-4 shadow items-center"
                        description="Proses pendaftaran magang 100% online melalui formulir digital."
                    />
                    <FeatureCard
                        :icon="CheckCircle2"
                        costumStyle="flex w-full flex-row  gap-5 rounded-2xl p-4 shadow items-center"
                        description="Catat kehadiran magang langsung via platform dengan sekali klik."
                    />
                    <FeatureCard
                        :icon="ClipboardList"
                        costumStyle="flex w-full flex-row  gap-5 rounded-2xl p-4 shadow items-center"
                        description="Rekam kegiatan magang harian melalui template laporan."
                    />
                    <FeatureCard
                        :icon="UploadCloud"
                        costumStyle="flex w-full flex-row  gap-5 rounded-2xl p-4 shadow items-center"
                        description="Upload dokumen pendukung penting ke dalam sistem."
                    />
                </div>
            </div>

            <div id="visi" class="bg-muted flex flex-col gap-4 p-4 md:gap-10 md:p-10 lg:flex-row lg:gap-20 lg:p-20">
                <div id="head" class="text-foreground flex flex-col gap-5 lg:w-1/3">
                    <p class="text-2xl font-bold">Visi Kami</p>
                    <p>
                        Menjadi platform digital magang terpercaya yang mendukung pengembangan potensi generasi muda di bidang perencanaan pembangunan
                        daerah.
                    </p>
                </div>
                <div id="content" class="flex w-full flex-col gap-4 md:flex-row md:gap-10 lg:gap-20">
                    <FeatureCard
                        :icon="FileSliders"
                        costumStyle=" bg-background flex w-full flex-row md:flex-col gap-5 rounded-2xl p-4 shadow items-center md:items-start"
                        title="Proses Magang"
                        description="Sistem yang mempermudah mahasiswa selama  masa magang mereka berlangsung"
                    />
                    <FeatureCard
                        :icon="CheckCircle2"
                        costumStyle=" bg-background flex w-full flex-row md:flex-col gap-5 rounded-2xl p-4 shadow items-center md:items-start"
                        title="Monitoring yang Transparan"
                        description="Kemudahan bagi admin BAPPEDA untuk memantau kegiatan magang"
                    />
                    <FeatureCard
                        :icon="ClipboardList"
                        costumStyle=" bg-background flex w-full flex-row md:flex-col gap-5 rounded-2xl p-4 shadow items-center md:items-start"
                        title="Inovasi Digital di Instansi Pemerintah"
                        description="Solusi teknologi sebagai langkah awal transformasi digital dalam  magang di pemerintahan."
                    />
                </div>
            </div>

            <div id="timeline_sistem" class="bg-background flex justify-between gap-4 px-4 py-10 md:px-10 flex-col lg:px-20">
                <TextContainer
                    class=""
                    caption="Perjananan pengembangan sistem"
                    title="Dari konsep hingga siap diguanakan"
                    description="Sistem Magang with BAPPEDA dikembangkan secara bertahap dengan pendekatan metodologi Waterfall, yang memastikan setiap fase dirancang dengan matang sebelum melangkah ke tahap berikutnya. Proses ini melibatkan analisis kebutuhan, perancangan sistem, pengembangan fitur, pengujian, hingga tahap akhir berupa perbaikan dan publikasi."
                    :button="false"
                />
                <TimelineCard :contents="contents" />
            </div>
        </main>
    </HomeLayout>
</template>
