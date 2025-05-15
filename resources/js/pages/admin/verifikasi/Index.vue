<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
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
    status: string;
}

interface Pendaftar {
    id: number;
    user: Auth;
    profile: Profile;
    posisi_magang: string;
    deskripsi_magang: string;
    tanggal_mulai: string | Date;
    tanggal_selesai: string | Date;
    surat_magang: string;
}

interface Verifikasi {
    current_page: number;
    last_page: number;
    next_page_url: string;
    prev_page_url: string;
    first_page_url: string;
    last_page_url: string;
    data: Pendaftar[];
    links: any;
}

interface Auth {
    user: {
        id: number;
        name: string;
        email: string;
        status: string;
    };
}

interface Props {
    verifikasi: Verifikasi;
    auth: Auth;
    errors: Record<string, string>;
    [key: string]: unknown;
}

const page = usePage<Props>();
const { verifikasi, auth, errors } = page.props;

const pagination = verifikasi as Verifikasi;
const pendaftar = verifikasi.data;

console.log(pendaftar);

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;

function goTo(url: string | null) {
    if (url) router.get(url);
}
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
                                <TableHead class="w-80 whitespace-pre-wrap break-words">Deskripsi magang</TableHead>
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
                                <TableCell class="w-80 whitespace-pre-wrap break-words">{{ daftar.deskripsi_magang }}</TableCell>
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
                                <PaginationFirst @click="goTo(pagination.first_page_url)" :disabled="!pagination.prev_page_url" />
                                <PaginationPrevious @click="goTo(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" />
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
