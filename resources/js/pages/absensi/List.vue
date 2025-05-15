<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Absensi',
        href: '/dashboard/absensi',
    },
    {
        title: 'Riwayat Absensi',
        href: 'riwayat',
    },
];

const props = defineProps({
    absen: {
        type: Object,
        required: true,
    },
    surat: {
        required: true,
    },
});

console.log(props);

const pagination = props.absen;
const absensi = pagination.data;

const currentPage = pagination.current_page;
const lastPage = pagination.last_page;
const links = pagination.links;

function goTo(url: string | null) {
    if (url) router.get(url);
}

const checkVariant = (variant: string) => {
    if (variant === 'Valid') return 'success';
    if (variant === 'Tidak Valid') return 'destructive';
    return 'pending';
};
</script>

<template>
    <Head title="Riwayat Absensi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col gap-5 p-5">
                <div class="flex flex-row gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">Riwayat</p>
                </div>
                <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
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
                            <TableRow v-for="(absen, index) in absensi" :key="index">
                                <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                                <TableCell>{{ absen.tanggal }}</TableCell>
                                <TableCell>{{ absen.status }}</TableCell>
                                <TableCell>{{ absen.keterangan || '-' }}</TableCell>
                                <TableCell> {{ absen.waktu_datang || absen.status }} </TableCell>
                                <TableCell> {{ absen.waktu_pulang || absen.status }} </TableCell>
                                <TableCell>
                                    <a
                                        v-if="absen.surat"
                                        :href="route('dashboard.absensi.surat', absen.surat.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat surat</a
                                    >
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
