<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
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

import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Absensi Mahasiswa',
        href: '/admin/dashboard/absensi',
    },
];

interface Profile {
    id: number;
    user_id: number;
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

interface Absen {
    current_page: number;
    last_page: number;
    next_page_url: string;
    prev_page_url: string;
    first_page_url: string;
    last_page_url: string;
    data: {
        id: number;
        profile: Profile;
        keterangan: string;
        status: string;
        tanggal: string | Date;
        waktu_datang: string;
        waktu_pulang: string;
        surat: string;
        verifikasi: string;
    }[];
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
    absen: Absen;
    auth: Auth;
    errors: Record<string, string>;
    [key: string]: unknown;
}

const page = usePage<Props>();
const { absen, auth, errors } = page.props;

const pagination = absen as Absen;
const absensi = absen.data;

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;

function goTo(url: string | null) {
    if (url) router.get(url);
}

const verifikasiAbsen = (value: string, absen: Absen['data'][0]) => {
    router.put(
        route('admin.dashboard.absensi.update', absen.id),
        {
            verifikasi: value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Berhasil memperbarui verifikasi');
            },
        },
    );
};
</script>

<template>
    <Head title="Absensi Mahasiswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">Riwayat absen</p>
                </div>
                <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                    <Table>
                        <TableCaption>Daftar absensi.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-fit">No</TableHead>
                                <TableHead>Tanggal</TableHead>
                                <TableHead>Nama</TableHead>
                                <TableHead>Bidang</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Keterangan</TableHead>
                                <TableHead>Jam Masuk</TableHead>
                                <TableHead>Jam Pulang</TableHead>
                                <TableHead>Surat</TableHead>
                                <TableHead>Verifikasi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(absen, index) in absensi" :key="index">
                                <TableCell class="w-fit font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell>{{ absen.tanggal }}</TableCell>
                                <TableCell>{{ absen.profile.nama_lengkap }}</TableCell>
                                <TableCell>{{ absen.profile.bidang_magang }}</TableCell>
                                <TableCell>{{ absen.status }}</TableCell>
                                <TableCell>{{ absen.keterangan || '-' }}</TableCell>
                                <TableCell>
                                    {{
                                        absen.waktu_datang || absen.status === 'Izin' || absen.status === 'Sakit'
                                            ? absen.waktu_datang || absen.status
                                            : '-'
                                    }}
                                </TableCell>
                                <TableCell>
                                    {{
                                        absen.waktu_pulang || absen.status === 'Izin' || absen.status === 'Sakit'
                                            ? absen.waktu_pulang || absen.status
                                            : '-'
                                    }}
                                </TableCell>
                                <TableCell>
                                    <a
                                        v-if="absen.surat"
                                        :href="route('admin.dashboard.absensi.surat', absen.surat.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat surat</a
                                    >
                                    <p v-else>-</p>
                                </TableCell>
                                <TableCell>
                                    <Select v-model="absen.verifikasi" @update:modelValue="(value) => verifikasiAbsen(value, absen)">
                                        <SelectTrigger>
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem value="Valid"> Valid </SelectItem>
                                                <SelectItem value="Tidak Valid"> Tidak Valid </SelectItem>
                                                <SelectItem value="Pending"> Pending </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
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
