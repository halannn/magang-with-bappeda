<script setup lang="ts">
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
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePagination } from '@/composables/usePagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, SertifikatItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { FileBadge } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Sertifikat',
        href: '/admin/dashboard/sertifikat',
    },
];

const {
    items: sertifikat,
    currentPage,
    lastPage,
    links,
    goTo,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
} = usePagination<SertifikatItem>('sertifikat');

const handleDestroy = (id: number) => {
    router.delete(route('admin.dashboard.sertifikat.delete', id));
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
                <Button>
                    <a :href="route('admin.dashboard.sertifikat.create')"> Tambah </a>
                </Button>
            </div>
            <div id="table" class="px-5">
                <div class="flex-flex-col gap-10 rounded-2xl shadow">
                    <Table>
                        <TableCaption>Daftar mahasiswa.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-fit">No</TableHead>
                                <TableHead>Nama</TableHead>
                                <TableHead>Asal kampus</TableHead>
                                <TableHead>Bidang magang</TableHead>
                                <TableHead>Lihat sertifikat</TableHead>
                                <TableHead>Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(daftar, index) in sertifikat" :key="index">
                                <TableCell class="w-fit font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell>{{ daftar.profile.nama_lengkap }}</TableCell>
                                <TableCell>{{ daftar.profile.asal_kampus }}</TableCell>
                                <TableCell>{{ daftar.profile.bidang_magang }}</TableCell>
                                <TableCell>
                                    <a
                                        v-if="daftar.file"
                                        :href="route('admin.dashboard.sertifikat.file', daftar.file.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat sertifikat</a
                                    >
                                    <p v-else>-</p>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-row gap-2">
                                        <Button variant="destructive" size="sm" @click="handleDestroy(daftar.id)"> Hapus </Button>
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
                                    <PaginationItem
                                        :value="Object.keys(link).length"
                                        v-if="!link.label.includes('Previous') && !link.label.includes('Next')"
                                    >
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
