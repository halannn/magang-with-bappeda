<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { LaporanItem, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
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
import { usePagination } from '../../composables/usePagination';

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

const {
    items: kegiatan,
    currentPage,
    lastPage,
    links,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
    goTo,
} = usePagination<LaporanItem>('laporan');
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
                                <PaginationFirst @click="goTo(firstPageUrl)" :disabled="!prevPageUrl" />
                                <PaginationPrevious @click="goTo(prevPageUrl)" :disabled="!prevPageUrl" />
                                <template v-for="(link, index) in links" :key="index">
                                    <PaginationItem v-if="!link.label.includes('Previous') && !link.label.includes('Next')">
                                        <Button
                                            class="h-9 w-9 p-0"
                                            :variant="link.active ? 'outline' : 'default'"
                                            @click="goTo(link.url)"
                                            v-html="link.label"
                                        />
                                    </PaginationItem>
                                </template>
                                <PaginationNext @click="goTo(nextPageUrl)" :disabled="!nextPageUrl" />
                                <PaginationLast @click="goTo(lastPageUrl)" :disabled="!nextPageUrl" />
                            </PaginationContent>
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
