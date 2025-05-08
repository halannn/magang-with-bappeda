<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { useForm as formValidated } from 'vee-validate';
import { computed, onMounted, ref } from 'vue';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Laporan kegiatan', href: '/dashboard/laporan-kegiatan' },
    { title: 'Edit kegiatan', href: 'edit-kegiatan' },
];

const props = defineProps({
    laporan: {
        type: Object,
        required: true,
    },
    error: {
        type: [Object, Array],
        required: true,
    },
});

const laporan = props.laporan[0];
const error = computed(() => props.error);

const df = new DateFormatter('en-US', { dateStyle: 'long' });
const value = computed({
    get: () => (values.tanggal ? parseDate(values.tanggal) : undefined),
    set: (val) => val,
});

const MAX_FILE_SIZE: number = 2 * 1024 * 1024;
const checkFileType = (file: File) => file.type === 'application/pdf';
const formSchema = toTypedSchema(
    z.object({
        tanggal: z.string().nonempty('Tanggal harus diisi.'),
        deskripsi_kegiatan: z.string().nonempty('Berikan deskripsi tentang kegiatan anda.'),
        hasil: z.string().nonempty('Berikan deskripsi tentang kegiatan anda.'),
        waktu: z.string().nonempty('Berikan deskripsi tentang kegiatan anda.'),
        dokumentasi: z
            .any()
            .optional()
            .superRefine((file, ctx) => {
                if (file === undefined || file === null) return;

                if (!(file instanceof File)) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        message: 'Mohon upload surat anda, ukuran file maksimal 2MB dengan format .pdf.',
                    });
                    return;
                }

                if (file.size > MAX_FILE_SIZE) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        message: 'Ukuran file maksimal 2MB',
                    });
                }

                if (!checkFileType(file)) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        message: 'Mohon upload dokumen dengan format .pdf.',
                    });
                }
            }),
    }),
);
const selectedFileName = ref<string | null>(null);
const veeValidate = formValidated({ validationSchema: formSchema });
const { setFieldValue, values } = veeValidate;

const form = useForm({
    tanggal: laporan.tanggal,
    deskripsi_kegiatan: laporan.deskripsi_kegiatan,
    hasil: laporan.hasil,
    waktu: laporan.waktu,
    dokumentasi: laporan.dokumentasi,
});
const onSubmit = veeValidate.handleSubmit((values) => {
    form.tanggal = values.tanggal;
    form.deskripsi_kegiatan = values.deskripsi_kegiatan;
    form.hasil = values.hasil;
    form.waktu = values.waktu;
    form.dokumentasi = values.dokumentasi ?? laporan.dokumentasi;

    router.post(
        route('dashboard.laporan.update', laporan.id),
        {
            _method: 'put',
            tanggal: form.tanggal,
            deskripsi_kegiatan: form.deskripsi_kegiatan,
            hasil: form.hasil,
            waktu: form.waktu,
            dokumentasi: form.dokumentasi,
        },
        {
            forceFormData: true,
        },
    );
});

onMounted(() => {
    setFieldValue('tanggal', laporan.tanggal);
    setFieldValue('deskripsi_kegiatan', laporan.deskripsi_kegiatan);
    setFieldValue('hasil', laporan.hasil);
    setFieldValue('waktu', laporan.waktu);
});
</script>

<template>
    <Head title="Edit Kegiatan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-4 rounded-xl p-4">
            <form class="w-9/10 space-y-8" @submit="onSubmit">
                <FormField v-slot="{ componentField }" name="tanggal">
                    <FormItem class="flex flex-col">
                        <FormLabel>Tanggal kegiatan</FormLabel>
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
                                    @update:model-value="setFieldValue('tanggal', $event?.toString())"
                                />
                            </PopoverContent>
                        </Popover>
                        <FormDescription> Silahkan pilih tanggal kegiatan anda </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_kegiatan">
                    <FormItem>
                        <FormLabel>Deskripsi</FormLabel>
                        <FormControl>
                            <Textarea placeholder="Deskripsi kegiatan" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan deskripsi pada kegiatan anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="hasil">
                    <FormItem>
                        <FormLabel>Hasil</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="Hasil kegiatan" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan hasil dari kegiatan anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="waktu">
                    <FormItem>
                        <FormLabel>Waktu</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="08:00-12:00" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan keterangan waktu dalam kegiatan anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField name="dokumentasi">
                    <FormItem>
                        <FormLabel>Dokumentasi</FormLabel>
                        <FormControl>
                            <Input
                                type="file"
                                accept="application/pdf"
                                @change="
                                    (e) => {
                                        const file = e.target.files?.[0] || null;
                                        setFieldValue('dokumentasi', file);
                                        selectedFileName.value = file ? file.name : null;
                                    }
                                "
                            />
                            <div v-if="laporan.dokumentasi" class="m-2">
                                <a
                                    :href="route('dashboard.laporan.dokumentasi', laporan.dokumentasi.split('/').pop())"
                                    target="_blank"
                                    class="text-sm underline"
                                >
                                    Lihat dokumentasi saat ini
                                </a>
                            </div>
                        </FormControl>
                        <FormDescription> Silahkan upload kembali jika anda ingin mengupdate dokumentasi. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div v-if="error" class="text-red-500">
                    {{ error }}
                </div>

                <div class="mt-10 flex flex-row justify-end-safe gap-5">
                    <a :href="route('dashboard.laporan.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </a>
                    <Button type="submit"> Edit kegiatan </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
