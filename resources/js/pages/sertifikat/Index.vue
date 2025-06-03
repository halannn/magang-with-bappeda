<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Auth, type BreadcrumbItem, Sertifikat } from '@/types';
import type { PageProps } from '@inertiajs/core';
import { Head, usePage } from '@inertiajs/vue3';
import { FileBadge } from 'lucide-vue-next';
import { ref } from 'vue';
import VuePdfEmbed from 'vue-pdf-embed';
import 'vue-pdf-embed/dist/styles/annotationLayer.css';
import 'vue-pdf-embed/dist/styles/textLayer.css';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/admin/dashboard' },
    { title: 'Sertifikat', href: '/admin/dashboard/sertifikat' },
];

interface Props extends PageProps {
    sertifikat: Sertifikat;
    auth: Auth;
    errors: Record<string, string>;
}

const page = usePage<Props>();
const { sertifikat, auth, errors } = page.props;

const pdfViewer = ref(null);
let pdfSource = ref('');

if (sertifikat !== null) {
    pdfSource = route('dashboard.sertifikat.file', sertifikat.file.split('/').pop());
}

const handleDownload = () => {
    if (pdfViewer.value) {
        const file = `sertifikat_${sertifikat.profile.nama_lengkap}.pdf`;
        pdfViewer.value.download(file);
    } else {
        console.warn('PDF belum dimuat');
    }
};
</script>

<template>
    <Head title="Sertifikat Mahasiswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <div id="head" class="flex flex-row justify-between gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <FileBadge :size="32" />
                    <p class="text-2xl font-bold">Sertifikat</p>
                </div>
            </div>
            
            <div v-if="pdfSource" class="flex w-full flex-col items-center justify-center gap-10 px-4">
                <VuePdfEmbed ref="pdfViewer" :source="pdfSource" class="w-full" />
                <Button class="w-fit" @click="handleDownload"> Unduh sertifikat </Button>
            </div>

            <div v-else class="flex h-full items-center justify-center">Belum terdapat sertifikat.</div>
        </div>
    </AppLayout>
</template>
