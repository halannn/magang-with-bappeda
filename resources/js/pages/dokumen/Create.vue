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
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { useForm as formValidated } from 'vee-validate';
import { computed } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard/' },
    { title: 'Dokumen', href: '/dashboard/dokumen' },
    { title: 'Tambah Dokumen', href: 'tambah-dokumen' },
];

const page = usePage();
const error = computed(() => page.props.errors.absen);

const df = new DateFormatter('en-US', { dateStyle: 'long' });

const MAX_FILE_SIZE = 5 * 1024 * 1024;

const checkFileType = (file: File) => file.type === 'application/pdf';

const formSchema = toTypedSchema(
    z.object({
        tanggal: z.string().nonempty('Tanggal harus diisi.'),
        deskripsi_dokumen: z.string().nonempty('Berikan deskripsi tentang kegiatan anda.'),
        file: z.any().superRefine((file, ctx) => {
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

const veeValidate = formValidated({ validationSchema: formSchema });
const { setFieldValue, values } = veeValidate;

const value = computed({
    get: () => (values.tanggal ? parseDate(values.tanggal) : undefined),
    set: (val) => val,
});

const onSubmit = veeValidate.handleSubmit((values) => {
    const formData = {
        tanggal: values.tanggal,
        deskripsi_dokumen: values.deskripsi_dokumen,
        file: values.file,
    };

    const form = useForm(formData);
    form.post(route('dashboard.dokumen.store'), {
        forceFormData: true,
        onSuccess: () => {
            toast.success('Berhasil menambah dokumen.');
        },
        onError: () => {
            toast.error('Gagal menambah dokumen.');
        },
    });
});
</script>

<template>
    <Head title="Lupa absen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-4 rounded-xl p-4">
            <form class="w-9/10 space-y-8" @submit="onSubmit">
                <FormField v-slot="{ componentField }" name="tanggal">
                    <FormItem class="flex flex-col">
                        <FormLabel>Tanggal Dokumen</FormLabel>
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
                        <FormDescription> Silahkan pilih tanggal pembuatan dokumen tersebut. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_dokumen">
                    <FormItem>
                        <FormLabel>Deskripsi</FormLabel>
                        <FormControl>
                            <Textarea placeholder="Deskripsi dokumen" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan deskripsi pada dokumen anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="file">
                    <FormItem>
                        <FormLabel>File</FormLabel>
                        <FormControl>
                            <Input type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                        <FormDescription> Silahkan upload file dokumen dengan format .pdf. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div v-if="error" class="text-red-500">
                    {{ error }}
                </div>

                <div class="mt-10 flex flex-row justify-end-safe gap-5">
                    <a :href="route('dashboard.dokumen.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </a>
                    <Button type="submit"> Tambah dokumen </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
