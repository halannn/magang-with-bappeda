<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Verifikasi, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CalendarClockIcon, ClockAlertIcon, FileTextIcon, FolderArchiveIcon, UserCheckIcon, UserSearchIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
];

const props = defineProps<{
    verifikasi: Object;
    mahasiswa: Object;
    absen: Object;
    laporan: Object;
    dokumen: Object;
}>();

const pendaftar = props.verifikasi as Verifikasi;

const checkVariant = (variant: string) => {
    if (variant === 'Valid') return 'success';
    if (variant === 'Tidak Valid') return 'destructive';
    return 'pending';
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:gap-8 md:p-8">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Mahasiswa Aktif</CardTitle>
                        <UserSearchIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-primary text-4xl font-bold">
                            {{ mahasiswa }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Absensi Bulan Ini</CardTitle>
                        <ClockAlertIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-primary text-4xl font-bold">
                            {{ absen }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Laporan Bulan Ini</CardTitle>
                        <FileTextIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-primary text-4xl font-bold">
                            {{ laporan }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Total Dokumen</CardTitle>
                        <FolderArchiveIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-primary text-4xl font-bold">
                            {{ dokumen }}
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Riwayat Verifikasi -->
            <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                <div id="head" class="flex flex-col gap-5 p-5">
                    <div class="flex flex-row gap-5">
                        <CalendarClockIcon class="h-6 w-6 2xl:h-8 2xl:w-8" />
                        <p class="font-bold 2xl:text-2xl">Riwayat Verifikasi</p>
                    </div>
                </div>

                <Table>
                    <TableCaption>Daftar mahasiswa.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-fit">No</TableHead>
                            <TableHead>Nama</TableHead>
                            <TableHead>Asal kampus</TableHead>
                            <TableHead>Posisi magang</TableHead>
                            <TableHead>Deskripsi magang</TableHead>
                            <TableHead>Tanggal mulai</TableHead>
                            <TableHead>Tanggal selesai</TableHead>
                            <TableHead>Surat</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(daftar, index) in pendaftar" :key="index">
                            <TableCell class="w-fit font-medium"> {{ daftar.id }} </TableCell>
                            <TableCell>{{ daftar.profile.nama_lengkap }}</TableCell>
                            <TableCell class="whitespace-pre-line">{{ daftar.profile.asal_kampus }}</TableCell>
                            <TableCell class="whitespace-pre-line">{{ daftar.posisi_magang }}</TableCell>
                            <TableCell class="whitespace-pre-line">{{ daftar.deskripsi_magang }}</TableCell>
                            <TableCell class="w-fit">{{ daftar.tanggal_mulai }}</TableCell>
                            <TableCell class="w-fit">{{ daftar.tanggal_selesai }}</TableCell>
                            <TableCell class="w-fit">
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
                            <TableCell class="w-fit">
                                <Badge :variant="checkVariant(daftar.profile.status_magang)">
                                    {{ daftar.profile.status_magang }}
                                </Badge>
                            </TableCell>
                            <TableCell>
                                <div class="flex flex-row gap-2">
                                    <a :href="route('admin.dashboard.verifikasi.edit', daftar.id)">
                                        <Button size="sm" class="text-sm"> Detail </Button>
                                    </a>
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="pendaftar.length === 0">
                            <TableCell colspan="9" class="text-center">Tidak ada data ditemukan.</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
