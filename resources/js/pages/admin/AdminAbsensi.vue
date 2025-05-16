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
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePagination } from '@/composables/usePagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { AbsenItem, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import 'dayjs/locale/id';
import { CalendarClockIcon } from 'lucide-vue-next';

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

const { items: absensi, currentPage, lastPage, links, goTo, firstPageUrl, prevPageUrl, nextPageUrl, lastPageUrl } = usePagination<AbsenItem>('absen');

const verifikasiAbsen = (value: any, absen: AbsenItem['data'][0]) => {
    router.put(
        route('admin.dashboard.absensi.update', absen.id),
        {
            verifikasi: value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Berhasil memperbarui verifikasi pada absen');
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
