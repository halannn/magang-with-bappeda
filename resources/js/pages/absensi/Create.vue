<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { useForm as formValidated } from 'vee-validate';
import { computed, ref } from 'vue';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Absensi', href: '/dashboard/absensi' },
    { title: 'Lupa absen', href: 'lupa-absen' },
];

const page = usePage();
const error = computed(() => page.props.errors.absen);
const absensi = page.props.absen as Array<any>;

const df = new DateFormatter('en-US', { dateStyle: 'long' });

const formSchema = toTypedSchema(
    z
        .object({
            tanggal: z.string().nonempty('Tanggal harus diisi.'),
            tipe: z.enum(['waktu_datang', 'waktu_pulang'], { required_error: 'Pilih tipe absensi.' }),
            waktu_datang: z
                .string()
                .regex(/^\d{2}:\d{2}$/, { message: 'Format waktu harus HH:MM, contoh: 08:00' })
                .optional(),
            waktu_pulang: z
                .string()
                .regex(/^\d{2}:\d{2}$/, { message: 'Format waktu harus HH:MM, contoh: 16:30' })
                .optional(),
            keterangan: z.string().max(255, { message: 'Keterangan maksimal 255 karakter.' }).optional(),
        })
        .superRefine((data, ctx) => {
            if (data.tipe === 'waktu_datang' && !data.waktu_datang) {
                ctx.addIssue({
                    path: ['waktu_datang'],
                    code: z.ZodIssueCode.custom,
                    message: 'Waktu datang harus diisi.',
                });
            }
            if (data.tipe === 'waktu_pulang' && !data.waktu_pulang) {
                ctx.addIssue({
                    path: ['waktu_pulang'],
                    code: z.ZodIssueCode.custom,
                    message: 'Waktu pulang harus diisi.',
                });
            }
        }),
);

const tipe = ref<'waktu_datang' | 'waktu_pulang'>();
const veeValidate = formValidated({ validationSchema: formSchema });
const { setFieldValue, values } = veeValidate;

const value = computed({
    get: () => (values.tanggal ? parseDate(values.tanggal) : undefined),
    set: (val) => val,
});

const onSubmit = veeValidate.handleSubmit((values) => {
    const absen = absensi.find((absen) => absen.tanggal === values.tanggal);

    const formData = {
        tanggal: values.tanggal,
        [values.tipe!]: values[values.tipe!],
        keterangan: values.keterangan,
        status: 'Hadir',
    };

    const form = useForm(formData);
    values.tipe === 'waktu_datang' ? form.post(route('dashboard.absensi.store')) : form.put(route('dashboard.absensi.update', absen.id));
});
</script>

<template>
    <Head title="Lupa absen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-4 rounded-xl p-4">
            <form class=" w-9/10 space-y-8" @submit="onSubmit">
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
                        <FormDescription> Silahkan pilih tanggal absensi anda </FormDescription>
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
                                    <SelectItem value="waktu_datang"> Absen Datang </SelectItem>
                                    <SelectItem value="waktu_pulang"> Absen Pulang </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <FormDescription> Silahkan pilih jenis absensi </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <template v-if="tipe === 'waktu_datang'">
                    <FormField v-slot="{ componentField }" name="waktu_datang">
                        <FormItem>
                            <FormLabel>Waktu Datang</FormLabel>
                            <FormControl>
                                <Input type="text" placeholder="08:00" v-bind="componentField" />
                            </FormControl>
                            <FormDescription> Contoh format: 08:00 </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </template>

                <template v-if="tipe === 'waktu_pulang'">
                    <FormField v-slot="{ componentField }" name="waktu_pulang">
                        <FormItem>
                            <FormLabel>Waktu Pulang</FormLabel>
                            <FormControl>
                                <Input type="text" placeholder="16:30" v-bind="componentField" />
                            </FormControl>
                            <FormDescription> Contoh format: 16:30 </FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </template>

                <FormField v-slot="{ componentField }" name="keterangan">
                    <FormItem>
                        <FormLabel>Keterangan</FormLabel>
                        <FormControl>
                            <Input type="text" placeholder="Terjebak banjir" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan alasan mengapa anda lupa absen. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <div v-if="error" class="text-red-500">
                    {{ error }}
                </div>

                <div class="flex flex-row gap-5 justify-end-safe mt-10">
                    <a :href="route('dashboard.absensi.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </a>
                    <Button type="submit"> Ajukan absen </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
