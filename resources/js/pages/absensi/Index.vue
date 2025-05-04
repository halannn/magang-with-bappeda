<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Progress } from '@/components/ui/progress';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import 'dayjs/locale/id';
import { CalendarClockIcon } from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Absensi',
        href: '/absensi',
    },
];

const page = usePage();

const tanggal = dayjs().format('YYYY-MM-DD');
const hariIni = dayjs().locale('id').format('dddd, DD MMMM YYYY');
const jam = ref(dayjs().locale('id').format('HH:mm'));

const absensi = page.props.absen as Array<any>;
const absenHariIni = computed(() => {
    return absensi.find((absen) => absen.tanggal === tanggal);
});

const form = useForm({
    tanggal,
    waktu_datang: '',
    waktu_pulang: '',
    status: 'hadir',
    absen_id: null,
});

let interval: number;

onMounted(() => {
    if (absenHariIni.value) {
        Object.assign(form, {
            tanggal: absenHariIni.value.tanggal,
            waktu_datang: absenHariIni.value.waktu_datang || '',
            waktu_pulang: absenHariIni.value.waktu_pulang || '',
            status: absenHariIni.value.status || 'hadir',
            absen_id: absenHariIni.value.id,
        });
    }

    interval = window.setInterval(() => {
        jam.value = dayjs().locale('id').format('HH:mm');
    }, 1000);
});

onUnmounted(() => clearInterval(interval));

const handleAbsenDatang = () => {
    form.waktu_datang = jam.value;
    form.post(route('absensi.store'), {
        preserveScroll: true,
        onSuccess: () => location.reload(),
    });
};

const handleAbsenPulang = () => {
    form.waktu_pulang = jam.value;
    if (form.absen_id) {
        form.put(route('absensi.update', form.absen_id), {
            preserveScroll: true,
            onSuccess: () => location.reload(),
        });
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div id="head" class="flex flex-col gap-5 p-5">
                <div class="flex flex-row justify-center gap-5">
                    <CalendarClockIcon :size="32" />
                    <p class="text-2xl font-bold">
                        {{ hariIni }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col justify-center gap-10">
                <div class="text-center text-8xl font-bold">
                    {{ jam }}
                </div>
                <div class="flex flex-row justify-center">
                    <Progress :model-value="33" class="w-1/4" />
                </div>
                <div class="flex flex-row justify-center gap-5">
                    <Button v-if="form.waktu_datang" variant="secondary" >
                        {{ form.waktu_datang }}
                    </Button>
                    <Button v-else type="button" @click="handleAbsenDatang">Absen Datang</Button>
                    <Button v-if="form.waktu_pulang" variant="secondary" >
                        {{ form.waktu_pulang }}
                    </Button>
                    <Button v-else type="button" @click="handleAbsenPulang"> Absen Pulang </Button>
                </div>
                <TextLink :href="route('absensi.create')" class="text-center underline underline-offset-4">Lupa absen?</TextLink>
            </div>

            <div class="flex-flex-col gap-10 rounded-2xl p-5 shadow">
                <div id="head" class="flex flex-col gap-5 p-5">
                    <div class="flex flex-row gap-5">
                        <CalendarClockIcon :size="32" />
                        <p class="text-2xl font-bold">Riwayat</p>
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
                        <TableRow v-for="(absen, index) in absensi.slice(0,5)" :key="index">
                            <TableCell class="font-medium"> {{ index + 1 }} </TableCell>
                            <TableCell>{{ absen.tanggal }}</TableCell>
                            <TableCell>{{ absen.status }}</TableCell>
                            <TableCell>{{ absen.keterangan || '-' }}</TableCell>
                            <TableCell> {{ absen.waktu_datang || absen.status }} </TableCell>
                            <TableCell> {{ absen.waktu_pulang || absen.status }} </TableCell>
                            <TableCell>
                                <a
                                    v-if="absen.surat"
                                    :href="route('absensi.surat', absen.surat.split('/').pop())"
                                    target="_blank"
                                    rel="noopener"
                                    class="underline"
                                    >Lihat surat</a
                                >
                                <p v-else>-</p>
                            </TableCell>
                            <TableCell>
                                <Badge variant="secondary">
                                    {{ absen.Verifikasi || 'Pending' }}
                                </Badge>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
