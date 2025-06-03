<script setup lang="ts">
import Alert from '@/components/Alert.vue';
import { Button } from '@/components/ui/button';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { useForm as formValidated } from 'vee-validate';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Absensi', href: '/dashboard/absensi' },
    { title: 'Izin atau sakit', href: '/dashboard/izin-sakit' },
];

const page = usePage();
const error = computed(() => page.props.errors.absen);

const df = new DateFormatter('id-ID', { dateStyle: 'full' });

const MAX_FILE_SIZE = 2 * 1024 * 1024;

const checkFileType = (file: File) => file.type === 'application/pdf';

const formSchema = toTypedSchema(
    z.object({
        tanggal: z.string().nonempty('Tanggal harus diisi.'),
        tipe: z.enum(['Izin', 'Sakit'], { required_error: 'Pilih tipe absensi.' }),
        keterangan: z.string().max(255, { message: 'Keterangan maksimal 255 karakter.' }),
        surat: z.any().superRefine((file, ctx) => {
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

const tipe = ref<'Izin' | 'Sakit'>();
const veeValidate = formValidated({ validationSchema: formSchema });
const { setFieldValue, values } = veeValidate;

const value = computed({
    get: () => (values.tanggal ? parseDate(values.tanggal) : undefined),
    set: (val) => val,
});

const onSubmit = veeValidate.handleSubmit((values) => {
    const formData = {
        tanggal: values.tanggal,
        keterangan: values.keterangan,
        status: values.tipe!,
        surat: values.surat,
    };

    const form = useForm(formData);

    form.post(route('dashboard.absensi.store'), {
        forceFormData: true,
        onSuccess: () => {
            toast.success('Berhasil mengajukan izin.');
        },
        onError: () => {
            toast.error('Gagal mengajukan izin.');
        },
    });
});
</script>

<template>
    <Head title="Lupa absen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-4 rounded-xl p-4">
            <form class="w-9/10 space-y-8" @submit.prevent>
                <FormField v-slot="{ componentField }" name="tanggal">
                    <FormItem class="flex flex-col">
                        <FormLabel>Tanggal absen</FormLabel>
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
                        <FormDescription> Silahkan pilih tanggal absensi anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="tipe">
                    <FormItem>
                        <FormLabel>Tipe Absen</FormLabel>
                        <Select v-bind="componentField" v-model="tipe">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih tipe absen" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="Izin"> Izin </SelectItem>
                                    <SelectItem value="Sakit"> Sakit </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <FormDescription> Silahkan pilih jenis absensi. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="keterangan">
                    <FormItem>
                        <FormLabel>Keterangan</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="Terjebak banjir" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan alasan anda.</FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="surat">
                    <FormItem>
                        <FormLabel>Surat keteragan</FormLabel>
                        <FormControl>
                            <Input type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                        <FormDescription> Silahkan upload surat atau berikan bukti (bisa dengan chat whatsapp). </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div v-if="error" class="text-red-500">
                    {{ error }}
                </div>

                <div class="mt-10 flex flex-row justify-end-safe gap-5">
                    <Link :href="route('dashboard.absensi.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </Link>
                    <Alert
                        dialog="Ajukan Izin"
                        title="Konfirmasi Pengiriman Data"
                        description="Pastikan data sudah benar sebelum mengirim."
                        :event="onSubmit"
                    />
                </div>
            </form>
        </div>
    </AppLayout>
</template>
