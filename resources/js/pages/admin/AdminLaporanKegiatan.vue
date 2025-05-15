<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import 'dayjs/locale/id';
import { CalendarClockIcon } from 'lucide-vue-next';

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
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Laporan Kegiatan',
        href: '/admin/dashboard/laporan-kegiatan',
    },
];

interface Auth {
    user: {
        id: number;
        name: string;
        email: string;
        status: string;
    };
}

interface Profile {
    id: number;
    user: Auth;
    nama_lengkap: string;
    nomor_mahasiswa: string;
    asal_kampus: string;
    fakultas: string;
    program_studi: string;
    deskripisi_diri: string;
    foto_profile: string;
    bidang_magang: string | null;
    status_magang: string;
}

interface Kegiatan {
    id: number;
    profile: Profile;
    tanggal: string;
    deskripsi_kegiatan: string;
    hasil: string;
    waktu: string;
    dokumentasi?: string | null;
}

interface Laporan {
    current_page: number;
    last_page: number;
    next_page_url: string;
    prev_page_url: string;
    first_page_url: string;
    last_page_url: string;
    data: Kegiatan[];
    links: any;
}

interface Props {
    laporan: Laporan;
    auth: Auth;
    errors: Record<string, string>;
    [key: string]: unknown;
}

const page = usePage<Props>();
const { laporan, auth, errors } = page.props;

console.log(laporan);

const pagination = laporan as Laporan;
const kegiatan = laporan.data;

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;
</script>

<template>
    <Head title="Laporan Kegiatan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col justify-between gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">Riwayat laporan</p>
                </div>
                <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                    <Table>
                        <TableCaption>Daftar laporan kegiatan.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>No</TableHead>
                                <TableHead>Tanggal</TableHead>
                                <TableHead>Nama</TableHead>
                                <TableHead>Bidang</TableHead>
                                <TableHead>Deksripsi Kegiatan</TableHead>
                                <TableHead>Hasil</TableHead>
                                <TableHead>Waktu</TableHead>
                                <TableHead>Dokumentasi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(item, index) in kegiatan" :key="index">
                                <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell>{{ item.tanggal }}</TableCell>
                                <TableCell>{{ item.profile.nama_lengkap }}</TableCell>
                                <TableCell>{{ item.profile.bidang_magang }}</TableCell>
                                <TableCell class="w-80 whitespace-pre-line">
                                    {{ item.deskripsi_kegiatan }}
                                </TableCell>
                                <TableCell class="w-80 whitespace-pre-line"> {{ item.hasil }} </TableCell>
                                <TableCell> {{ item.waktu }} </TableCell>
                                <TableCell>
                                    <a
                                        v-if="item.dokumentasi"
                                        :href="route('dashboard.laporan.dokumentasi', item.dokumentasi.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat dokumentasi</a
                                    >
                                    <p v-else>-</p>
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
        </div>
    </AppLayout>
</template>
