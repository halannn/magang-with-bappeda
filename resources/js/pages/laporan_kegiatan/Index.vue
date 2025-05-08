<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import 'dayjs/locale/id';
import { CalendarClockIcon } from 'lucide-vue-next';

import Button from '@/components/ui/button/Button.vue';
import {
    Pagination,
    PaginationContent,
    PaginationFirst,
    PaginationItem,
    PaginationLast,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Laporan Kegiatan',
        href: '/dashboard/laporan-kegiatan',
    },
];

const props = defineProps({
    laporan: {
        type: Object,
        required: true,
    },
    dokumentasi: {
        type: [Object, Array],
        required: true,
    },
});

interface Pagination<T> {
    current_page: number;
    last_page: number;
    first_page_url: string | null;
    prev_page_url: string | null;
    next_page_url: string | null;
    last_page_url: string | null;
    data: T[];
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

interface Kegiatan {
    id: number;
    profile_id: number;
    tanggal: string;
    deskripsi_kegiatan: string;
    hasil: string;
    waktu: string;
    dokumentasi?: string | null;
}

const pagination = props.laporan as Pagination<Kegiatan>;
const kegiatan: Kegiatan[] = pagination.data;

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;

function goTo(url: string | null) {
    if (url) router.get(url);
}

const handleDestroy = (id: number) => {
    router.delete(route('dashboard.laporan.destroy', id), {});
};
</script>

<template>
    <Head title="Laporan Kegiatan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-row justify-between gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">Riwayat</p>
                </div>
                <Button>
                    <a :href="route('dashboard.laporan.create')"> Tambah </a>
                </Button>
            </div>
            <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                <Table>
                    <TableCaption>Daftar laporan kegiatan.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>No</TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead>Deksripsi Kegiatan</TableHead>
                            <TableHead>Hasil</TableHead>
                            <TableHead>Waktu</TableHead>
                            <TableHead>Dokumentasi</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(keterangan, index) in kegiatan" :key="index">
                            <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                            <TableCell>{{ keterangan.tanggal }}</TableCell>
                            <TableCell class="w-80 whitespace-pre-line">
                                {{ keterangan.deskripsi_kegiatan }}
                            </TableCell>
                            <TableCell class="w-80 whitespace-pre-line"> {{ keterangan.hasil }} </TableCell>
                            <TableCell> {{ keterangan.waktu }} </TableCell>
                            <TableCell>
                                <a
                                    v-if="keterangan.dokumentasi"
                                    :href="route('dashboard.laporan.dokumentasi', keterangan.dokumentasi.split('/').pop())"
                                    target="_blank"
                                    rel="noopener"
                                    class="underline"
                                    >Lihat dokumentasi</a
                                >
                                <p v-else>-</p>
                            </TableCell>
                            <TableCell>
                                <div class="flex flex-row gap-2">
                                    <a :href="route('dashboard.laporan.edit', keterangan.id)">
                                        <Button size="sm"> Edit </Button>
                                    </a>
                                    <Button variant="destructive" size="sm" @click="handleDestroy(keterangan.id)"> Hapus </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <div class="mt-5">
                    <Pagination :total="lastPage" :items-per-page="7" :default-page="currentPage" :sibling-count="1" show-edges>
                        <PaginationContent class="flex items-center gap-1">
                            <PaginationFirst @click="goTo(pagination.first_page_url)" :disabled="!pagination.prev_page_url" />
                            <PaginationPrevious @click="goTo(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" />
                            <template v-for="(link, index) in links" :key="index">
                                <template v-if="!link.label.includes('Previous') && !link.label.includes('Next')">
                                    <PaginationItem :isActive="link.active" @click="goTo(link.url)" v-html="link.label" />
                                </template>
                            </template>
                            <PaginationNext @click="goTo(pagination.next_page_url)" :disabled="!pagination.next_page_url" />
                            <PaginationLast @click="goTo(pagination.last_page_url)" :disabled="!pagination.next_page_url" />
                        </PaginationContent>
                    </Pagination>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
