<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, VerifikasiItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import 'dayjs/locale/id';
import { ListCheckIcon } from 'lucide-vue-next';

import {
    Pagination,
    PaginationContent,
    PaginationFirst,
    PaginationItem,
    PaginationLast,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { usePagination } from '@/composables/usePagination';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Verifkasi Mahasiswa',
        href: '/admin/dashboard/verifikasi',
    },
];

const {
    items: pendaftar,
    currentPage,
    lastPage,
    links,
    goTo,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
} = usePagination<VerifikasiItem>('verifikasi');
</script>

<template>
    <Head title="Verifikasi Mahasiswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <ListCheckIcon :size="32" />
                    <p class="text-2xl font-bold">Data Mahasiswa</p>
                </div>
                <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                    <Table>
                        <TableCaption>Daftar mahasiswa.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-fit">No</TableHead>
                                <TableHead>Nama</TableHead>
                                <TableHead>Asal kampus</TableHead>
                                <TableHead>Posisi magang</TableHead>
                                <TableHead class="w-80 break-words whitespace-pre-wrap">Deskripsi magang</TableHead>
                                <TableHead>Tanggal mulai</TableHead>
                                <TableHead>Tanggal selesai</TableHead>
                                <TableHead>Proposal magang</TableHead>
                                <TableHead>Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(daftar, index) in pendaftar" :key="index">
                                <TableCell class="w-fit font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell>{{ daftar.profile.nama_lengkap }}</TableCell>
                                <TableCell>{{ daftar.profile.asal_kampus }}</TableCell>
                                <TableCell>{{ daftar.posisi_magang }}</TableCell>
                                <TableCell class="w-80 break-words whitespace-pre-wrap">{{ daftar.deskripsi_magang }}</TableCell>
                                <TableCell>{{ daftar.tanggal_mulai }}</TableCell>
                                <TableCell>{{ daftar.tanggal_selesai }}</TableCell>
                                <TableCell>
                                    <a
                                        v-if="daftar.surat_magang"
                                        :href="route('admin.dashboard.verifikasi.proposal', daftar.surat_magang.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat surat</a
                                    >
                                    <p v-else>-</p>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-row gap-2">
                                        <a :href="route('admin.dashboard.verifikasi.edit', daftar.id)">
                                            <Button size="sm" class="text-sm"> Detail </Button>
                                        </a>
                                    </div>
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
