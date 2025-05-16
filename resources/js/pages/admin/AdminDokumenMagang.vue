<script setup lang="ts">
import { Button } from '@/components/ui/button';
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
import { DokumenItem, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { FileClockIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Dokumen',
        href: '/dashboard/dokumen',
    },
];

const {
    items: dokumen,
    currentPage,
    lastPage,
    links,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
    goTo,
} = usePagination<DokumenItem>('dokumen');

const handleDestroy = (id: number) => {
    router.delete(route('admin.dashboard.dokumen.destroy', id), {});
};
</script>

<template>
    <Head title="Dokumen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col justify-between gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <FileClockIcon :size="32" />
                    <p class="text-2xl font-bold">Dokumen Magang</p>
                </div>
                <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                    <Table>
                        <TableCaption>Daftar Dokumen Magang.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>No</TableHead>
                                <TableHead class="w-full">Deksripsi Dokumen</TableHead>
                                <TableHead>Tanggal</TableHead>
                                <TableHead>File</TableHead>
                                <TableHead>Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(item, index) in dokumen" :key="index">
                                <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell class="whitespace-normal">
                                    {{ item.deskripsi_dokumen }}
                                </TableCell>
                                <TableCell>{{ item.tanggal }}</TableCell>
                                <TableCell>
                                    <a
                                        v-if="item.file"
                                        :href="route('admin.dashboard.dokumen.file', item.file.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat file</a
                                    >
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-row gap-2">
                                        <Button variant="destructive" size="sm" @click="handleDestroy(item.id)"> Hapus </Button>
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
