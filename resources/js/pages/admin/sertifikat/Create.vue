<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import '@/fonts/montserrat-normal.js';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { Auth, BreadcrumbItem, Verifikasi } from '@/types';
import type { PageProps } from '@inertiajs/core';
import { Head, router, usePage } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { jsPDF } from 'jspdf';
import { CalendarIcon } from 'lucide-vue-next';
import { toDate } from 'reka-ui/date';
import { useForm } from 'vee-validate';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/admin/dashboard' },
    { title: 'Sertifikat', href: '/admin/dashboard/sertifikat' },
    { title: 'Buat Sertifikat', href: '/admin/dashboard/sertifikat/tambah-sertifikat' },
];

interface Props extends PageProps {
    pendaftar: Verifikasi;
    auth: Auth;
    errors: Record<string, string>;
}

const page = usePage<Props>();
const { pendaftar, auth, errors } = page.props;

const formSchema = toTypedSchema(
    z.object({
        profile: z.string().nonempty('Pilih mahassiwa.'),
        tanggal_terbit: z.string().nonempty('Tanggal harus diisi.'),
        asal_kampus: z.string().min(2),
        tanggal_mulai: z.string().nonempty('Tanggal harus diisi.'),
        tanggal_selesai: z.string().nonempty('Tanggal harus diisi.'),
    }),
);

const form = useForm({ validationSchema: formSchema });
const { handleSubmit, values, setFieldValue } = form;

const df = new DateFormatter('id-ID', { dateStyle: 'full' });
const value = computed({
    get: () => (values.tanggal_terbit ? parseDate(values.tanggal_terbit) : undefined),
    set: (val) => val,
});
const placeholder = ref();
const value1 = computed({
    get: () => (values.tanggal_mulai ? parseDate(values.tanggal_mulai) : undefined),
    set: (val) => val,
});
const value2 = computed({
    get: () => (values.tanggal_selesai ? parseDate(values.tanggal_selesai) : undefined),
    set: (val) => val,
});

const generatePDF = async (nama: string, asal_kampus: string, tanggal_mulai: string, tanggal_selesai: string): Promise<Blob> => {
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'px',
        format: [2000, 1414],
    });

    doc.setFont('Montserrat-Regular');
    doc.setTextColor('#03111E');

    const img = await loadImage('/SERTIFIKAT.png');
    doc.addImage(img, 'PNG', 0, 0, 2000, 1414);

    // nama
    let fontSize = 80;
    const maxWidth = 1180;
    const text = nama;
    doc.setFontSize(fontSize);
    while (doc.getTextWidth(text) > maxWidth && fontSize > 1) {
        fontSize--;
        doc.setFontSize(fontSize);
    }
    const textWidth = doc.getTextWidth(text);
    const areaX = (2000 - maxWidth) / 2;
    const textX = areaX + (maxWidth - textWidth) / 2;
    doc.text(text, textX, 620);

    // paragraf
    let fontSizeParagraf = 48;
    doc.setFontSize(fontSizeParagraf);
    const paragraf = `Telah menyelesaikan program magang sebagai mahasiswa dari ${asal_kampus} di BAPPEDA LITBANG Kota Balikpapan, periode ${tanggal_mulai} – ${tanggal_selesai}.`;
    doc.text(paragraf, 1000, 760, {
        maxWidth: 1180,
        align: 'center',
    });

    // convert to Blob
    const pdfBlob = doc.output('blob');
    return pdfBlob;
};
z;

const loadImage = (url: any) => {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => resolve(img);
        img.src = url;
    });
};

const onSubmit = handleSubmit(async (values) => {
    const selectedPendaftar = pendaftar.find((item) => item.profile.nama_lengkap === values.profile);

    const blob = await generatePDF(values.profile, values.asal_kampus, values.tanggal_mulai, values.tanggal_selesai);

    const formData = new FormData();
    formData.append('tanggal_terbit', values.tanggal_terbit);
    formData.append('file', blob, `Sertifikat_${values.profile}.pdf`);
    formData.append('profile_id', selectedPendaftar.profile.id);
    router.post(route('admin.dashboard.sertifikat.post'), formData, {
        onSuccess: () => {
            toast.success('Berhasil membuat sertifikat.');
        },
        onError: () => {
            toast.error('Gagal membuat sertifikat.');
        },
    });
});
</script>

<template>
    <Head title="Buat Sertifikat" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center gap-4 rounded-xl p-4">
            <form @submit="onSubmit" class="w-9/10 space-y-8">
                <FormField v-slot="{ componentField }" name="profile">
                    <FormItem>
                        <FormLabel>Nama mahasiswa</FormLabel>
                        <Select v-bind="componentField">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih mahasiswa" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup v-for="(item, index) in pendaftar">
                                    <SelectItem :value="item.profile.nama_lengkap"> {{ item.profile.nama_lengkap }} </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="tanggal_terbit">
                    <FormItem class="flex flex-col">
                        <FormLabel>Tanggal terbit</FormLabel>
                        <Popover>
                            <PopoverTrigger as-child>
                                <FormControl>
                                    <Button variant="outline" :class="cn('w-full ps-3 text-start font-normal', !value && 'text-muted-foreground')">
                                        <span>{{ value ? df.format(value.toDate(getLocalTimeZone())) : 'Pilih hari' }}</span>
                                        <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                                    </Button>
                                    <input hidden v-bind="componentField" />
                                </FormControl>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar
                                    v-model="value"
                                    calendar-label="tanggal"
                                    :min-value="new CalendarDate(2000, 1, 1)"
                                    :max-value="today(getLocalTimeZone())"
                                    @update:model-value="setFieldValue('tanggal_terbit', $event?.toString())"
                                />
                            </PopoverContent>
                        </Popover>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="asal_kampus">
                    <FormItem>
                        <FormLabel>Asal kampus</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField name="tanggal_mulai">
                    <FormItem class="flex w-full flex-col">
                        <FormLabel>Tanggal mulai</FormLabel>
                        <Popover>
                            <PopoverTrigger as-child>
                                <FormControl>
                                    <Button variant="outline" :class="cn('w-full ps-3 text-start font-normal', !value1 && 'text-muted-foreground')">
                                        <span>{{ value1 ? df.format(toDate(value1)) : 'Pilih hari' }}</span>
                                        <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                                    </Button>
                                    <input hidden />
                                </FormControl>
                            </PopoverTrigger>
                            <PopoverContent class="w-full p-0">
                                <Calendar
                                    v-model:placeholder="placeholder"
                                    v-model="value1"
                                    calendar-label="tanggal_mulai"
                                    initial-focus
                                    :min-value="new CalendarDate(1900, 1, 1)"
                                    :max-value="today(getLocalTimeZone())"
                                    @update:model-value="
                                        (v) => {
                                            if (v) {
                                                setFieldValue('tanggal_mulai', v.toString());
                                            } else {
                                                setFieldValue('tanggal_mulai', undefined);
                                            }
                                        }
                                    "
                                />
                            </PopoverContent>
                        </Popover>
                    </FormItem>
                </FormField>

                <FormField name="tanggal_selesai">
                    <FormItem class="flex w-full flex-col">
                        <FormLabel>Tanggal selesai</FormLabel>
                        <Popover>
                            <PopoverTrigger as-child>
                                <FormControl>
                                    <Button variant="outline" :class="cn('w-full ps-3 text-start font-normal', !value2 && 'text-muted-foreground')">
                                        <span>{{ value2 ? df.format(toDate(value2)) : 'Pilih hari' }}</span>
                                        <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                                    </Button>
                                    <input hidden />
                                </FormControl>
                            </PopoverTrigger>
                            <PopoverContent class="w-full p-0">
                                <Calendar
                                    v-model:placeholder="placeholder"
                                    v-model="value2"
                                    calendar-label="Date of birth"
                                    initial-focus
                                    :min-value="new CalendarDate(1900, 1, 1)"
                                    @update:model-value="
                                        (v) => {
                                            if (v) {
                                                setFieldValue('tanggal_selesai', v.toString());
                                            } else {
                                                setFieldValue('tanggal_selesai', undefined);
                                            }
                                        }
                                    "
                                />
                            </PopoverContent>
                        </Popover>
                    </FormItem>
                </FormField>

                <div class="mt-10 flex flex-row justify-end-safe gap-5">
                    <a :href="route('admin.dashboard.sertifikat.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </a>
                    <Button type="submit"> Buat sertifikat </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
