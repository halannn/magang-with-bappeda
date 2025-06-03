<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Calendar } from '@/components/ui/calendar';
import { Input } from '@/components/ui/input';
import { Pagination, PaginationContent, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePagination } from '@/composables/usePagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { AbsenItem, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { DateFormatter, DateValue, getLocalTimeZone, today } from '@internationalized/date';
import 'dayjs/locale/id';
import { CalendarClockIcon, CalendarIcon, Search } from 'lucide-vue-next';
import { toast } from 'vue-sonner';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/admin/dashboard' },
    { title: 'Absensi Mahasiswa', href: '/admin/dashboard/absensi' },
];

const {
    items: absensi,
    to,
    from,
    total,
    visibleLinks,
    currentPage,
    lastPage,
    links,
    goTo,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
} = usePagination<AbsenItem>('absen');

const df = new DateFormatter('id-ID', {
    dateStyle: 'full',
});

const items = [
    { value: 1, label: 'Kemarin' },
    { value: 3, label: '3 Hari' },
    { value: 7, label: '7 Hari' },
    { value: 30, label: '30 Hari' },
];

const search = ref<string>();
const selectedDate = ref<DateValue>();
const rows = ref<number>();

watch([search, selectedDate, rows], () => {
    router.get(
        '/admin/dashboard/absensi',
        {
            search: search.value,
            date: selectedDate.value ? selectedDate.value.toString() : null,
            rows: rows.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
});

const verifikasiAbsen = (value: any, absen: AbsenItem['data'][0]) => {
    router.put(
        route('admin.dashboard.absensi.update', absen.id),
        {
            verifikasi: value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
               toast.success('Berhasil memperbarui validasi pada absen');
            },
        },
    );
};
</script>

<template>
    <Head title="Absensi Mahasiswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col gap-10 p-5">
                <div class="flex flex-row gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">Riwayat absen</p>
                </div>

                <div class="flex flex-row items-center justify-between gap-4">
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button
                                variant="outline"
                                :class="cn('w-[280px] justify-start text-left font-normal', !selectedDate && 'text-muted-foreground')"
                            >
                                <CalendarIcon class="mr-2 h-4 w-4" />
                                {{ selectedDate ? df.format(selectedDate.toDate(getLocalTimeZone())) : 'Pilih tanggal' }}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="flex w-auto flex-col gap-y-2 p-2">
                            <Select
                                @update:model-value="
                                    (v) => {
                                        if (!v) return;
                                        selectedDate = today(getLocalTimeZone()).subtract({ days: Number(v) });
                                    }
                                "
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Select" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="item in items" :key="item.value" :value="item.value.toString()">
                                        {{ item.label }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <Calendar v-model="selectedDate" />
                        </PopoverContent>
                    </Popover>

                    <div class="relative w-full max-w-sm items-center">
                        <Input v-model="search" id="search" type="text" placeholder="Cari nama atau bidang" class="pl-10" />
                        <span class="absolute inset-y-0 start-0 flex items-center justify-center px-2">
                            <Search class="text-muted-foreground size-6" />
                        </span>
                    </div>
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
                                <TableHead>Validasi</TableHead>
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
                </div>
                <div class="flex flex-row justify-between">
                    <div class="flex w-full items-center">
                        <p v-if="total > 1">Menampilkan {{ to }} dari {{ total }} data</p>
                    </div>
                    <div class="flex flex-row gap-4">
                        <Select v-model="rows">
                            <SelectTrigger>
                                <SelectValue placeholder="Baris" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem :value="10"> 10 </SelectItem>
                                    <SelectItem :value="15"> 15 </SelectItem>
                                    <SelectItem :value="25"> 25 </SelectItem>
                                    <SelectItem :value="50"> 50 </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <Pagination :total="lastPage" :items-per-page="Number(rows)" :default-page="currentPage" show-edges>
                            <PaginationContent class="flex items-center gap-1">
                                <!-- <PaginationFirst @click="goTo(firstPageUrl)" :disabled="!prevPageUrl" /> -->
                                <PaginationPrevious @click="goTo(prevPageUrl)" :disabled="!prevPageUrl" />
                                <template v-for="(link, index) in visibleLinks" :key="index">
                                    <PaginationEllipsis v-if="link.label === '...'" />
                                    <PaginationItem v-else :value="index">
                                        <Button
                                            class="h-9 w-9 p-0"
                                            :variant="link.active ? 'default' : 'outline'"
                                            @click="goTo(link.url)"
                                            v-html="link.label"
                                        />
                                    </PaginationItem>
                                </template>
                                <PaginationNext @click="goTo(nextPageUrl)" :disabled="!nextPageUrl" />
                                <!-- <PaginationLast @click="goTo(lastPageUrl)" :disabled="!nextPageUrl" /> -->
                            </PaginationContent>
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
