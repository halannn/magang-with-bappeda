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
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { FileClockIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dokumen',
        href: '/dokumen',
    },
];

const props = defineProps({
    dokumen: {
        type: Object,
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

interface Dokumen {
    id: number;
    profile_id: number;
    deskripsi_dokumen: string;
    tanggal: string;
    file: string;
}

const pagination = props.dokumen as Pagination<Dokumen>;
const dokumen: Dokumen[] = pagination.data;

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;

function goTo(url: string | null) {
    if (url) router.get(url);
}

const handleDestroy = (id: number) => {
    router.delete(route('dokumen.destroy', id), {});
};
</script>

<template>
    <Head title="Dokumen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-row justify-between gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <FileClockIcon :size="32" />
                    <p class="text-2xl font-bold">Dokumen Magang</p>
                </div>
                <Button>
                    <a :href="route('dokumen.create')"> Tambah </a>
                </Button>
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
                                    :href="route('dokumen.file', item.file.split('/').pop())"
                                    target="_blank"
                                    rel="noopener"
                                    class="underline"
                                    >Lihat file</a
                                >
                            </TableCell>
                            <TableCell>
                                <div class="flex flex-row gap-2">
                                    <a :href="route('dokumen.edit', item.id)">
                                        <Button size="sm"> Edit </Button>
                                    </a>
                                    <Button variant="destructive" size="sm" @click="handleDestroy(item.id)"> Hapus </Button>
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
