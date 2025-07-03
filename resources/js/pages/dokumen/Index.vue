<script setup lang="ts">
import Alert from '@/components/Alert.vue';
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
import { DokumenItem, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { DateFormatter, DateValue, getLocalTimeZone, today } from '@internationalized/date';
import 'dayjs/locale/id';
import { CalendarIcon, FileClockIcon, Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const df = new DateFormatter('id-ID', {
    dateStyle: 'full',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Laporan Kegiatan',
        href: '/dashboard/dokumen',
    },
];

const {
    items: dokumen,
    from,
    to,
    total,
    currentPage,
    lastPage,
    links,
    goTo,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
    visibleLinks,
} = usePagination<DokumenItem>('dokumen');

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
        '/dashboard/dokumen',
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

const handleDestroy = (id: number) => {
    router.delete(route('dashboard.dokumen.destroy', id), {
        onSuccess: () => {
            toast.success('Berhasil menghapus dokumen.');
        },
        onError: () => {
            toast.error('Gagal menghapus dokumen.');
        },
    });
};
</script>

<template>
    <Head title="Dokumen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="content" class="flex flex-col gap-10 p-5">
                <div class="flex flex-row justify-between">
                    <div class="flex flex-row gap-5">
                        <FileClockIcon :size="32" />
                        <p class="text-2xl font-bold">Dokumen Magang</p>
                    </div>
                    <Button>
                        <a :href="route('dashboard.dokumen.create')"> Tambah </a>
                    </Button>
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
                                        :href="route('dashboard.dokumen.file', item.file.split('/').pop())"
                                        target="_blank"
                                        rel="noopener"
                                        class="underline"
                                        >Lihat file</a
                                    >
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-row gap-2">
                                        <a :href="route('dashboard.dokumen.edit', item.id)">
                                            <Button size="sm"> Edit </Button>
                                        </a>
                                        <Alert
                                            dialog="Hapus"
                                            dialogClass="bg-destructive hover:bg-destructive"
                                            variant="destructive"
                                            size="sm"
                                            title="Konfirmasi Penghapusan Data"
                                            description="Pastikan data sudah benar sebelum dihapus."
                                            :event="() => handleDestroy(item.id)"
                                        />
                                    </div>
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
