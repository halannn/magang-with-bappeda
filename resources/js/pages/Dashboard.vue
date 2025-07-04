<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CalendarClockIcon, FileTextIcon, FolderArchiveIcon, UserCheckIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    absen: Object;
    absenCount: Object;
    laporan: Object;
    dokumen: Object;
}>();
const absensi = props.absen;

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
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Absensi Bulan Ini</CardTitle>
                        <UserCheckIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-4xl font-bold text-primary">
                            {{ absenCount }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2 font-bold">
                        <CardTitle>Laporan Bulan Ini</CardTitle>
                        <FileTextIcon />
                    </CardHeader>
                    <CardContent>
                        <div class="text-4xl font-bold text-primary">
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
                        <div class="text-4xl font-bold text-primary">
                            {{ dokumen }}
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Riwayat Absen -->
            <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                <div id="head" class="flex flex-col gap-5 p-5">
                    <div class="flex flex-row gap-5">
                        <CalendarClockIcon class="h-6 w-6 2xl:h-8 2xl:w-8" />
                        <p class="font-bold 2xl:text-2xl">Riwayat Absen</p>
                    </div>
                </div>

                <Table>
                    <TableCaption>Daftar absensi.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">No</TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Keterangan</TableHead>
                            <TableHead>Jam Masuk</TableHead>
                            <TableHead>Jam Pulang</TableHead>
                            <TableHead>Surat</TableHead>
                            <TableHead>Verifikasi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(absen, index) in absensi.slice(0, 5)" :key="index">
                            <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                            <TableCell>{{ absen.tanggal }}</TableCell>
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
                                    :href="route('dashboard.absensi.surat', absen.surat.split('/').pop())"
                                    target="_blank"
                                    rel="noopener"
                                    class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    >Lihat surat
                                </a>
                                <p v-else>-</p>
                            </TableCell>
                            <TableCell>
                                <Badge :variant="checkVariant(absen.verifikasi)">
                                    {{ absen.verifikasi }}
                                </Badge>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
