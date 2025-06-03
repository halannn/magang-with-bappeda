<script setup lang="ts">
import Alert from '@/components/Alert.vue';
import TextContainer from '@/components/TextContainer.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Textarea } from '@/components/ui/textarea';
import HomeLayout from '@/layouts/HomeLayout.vue';
import { cn } from '@/lib/utils';
import { Head, router } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { toDate } from 'reka-ui/date';
import { useForm } from 'vee-validate';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

const MAX_FILE_SIZE = 2 * 1024 * 1024;
function checkFileType(file: File) {
    if (file?.name) {
        const fileType = file.name.split('.').pop();
        if (fileType === 'pdf') return true;
    }
    return false;
}

const df = new DateFormatter('id-ID', { dateStyle: 'full' });

const formSchema = toTypedSchema(
    z.object({
        posisi_magang: z.string().min(2).max(50),
        deskripsi_magang: z.string().min(2),
        tanggal_mulai: z.string().nonempty('Tanggal harus diisi.'),
        tanggal_selesai: z.string().nonempty('Tanggal harus diisi.'),
        surat_magang: z
            .any()
            .refine((file) => file instanceof File, 'File diperlukan')
            .refine((file) => file?.size < MAX_FILE_SIZE, 'Max size is 2MB.')
            .refine((file) => checkFileType(file), 'Hanya format .pdf yang didukung.'),
    }),
);

const placeholder = ref();

const { handleSubmit, setFieldValue, values } = useForm({ validationSchema: formSchema });

const value1 = computed({
    get: () => (values.tanggal_mulai ? parseDate(values.tanggal_mulai) : undefined),
    set: (val) => val,
});
const value2 = computed({
    get: () => (values.tanggal_selesai ? parseDate(values.tanggal_selesai) : undefined),
    set: (val) => val,
});

const onSubmit = handleSubmit((values) => {
    console.log('Form submitted!', values);

    router.post(route('pendaftaran.magang.store'), values, {
        forceFormData: true,
        onSuccess: () => {
            toast.success('Berhasil mengirim data.');
        },
        onError: () => {
            toast.error('Gagal mengirim data. Periksa kembali input Anda.');
        },
    });
});
</script>

<template>
    <Head title="Form Magang" />

    <HomeLayout>
        <main class="mt-18 flex flex-col gap-6 p-4 md:p-10 lg:p-20">
            <TextContainer title="Form magang" description="Silahkan mengisi keterangan magang anda." :button="false" />
            <form @submit.prevent class="flex flex-col gap-6">
                <FormField v-slot="{ componentField }" name="posisi_magang">
                    <FormItem>
                        <FormLabel>Posisi magang</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Berikan posisi yang anda harapan. Contoh : Data analyst. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_magang">
                    <FormItem>
                        <FormLabel>Deskripsi magang</FormLabel>
                        <FormControl>
                            <Textarea v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Jelaskan dengan detail tentang harapan anda saat menjalani magang nantinya. </FormDescription>
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
                        <FormDescription> Silahkan masukan tanggal mulai magang anda. </FormDescription>
                        <FormMessage />
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
                        <FormDescription> Silahkan masukan tanggal selesai magang anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="surat_magang">
                    <FormItem>
                        <FormLabel>Surat atau proposal magang</FormLabel>
                        <FormControl>
                            <Input type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                        <FormDescription> Upload dokumen dengan format pdf. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <Alert
                    dialog="Konfirmasi"
                    title="Konfirmasi Pengiriman Data"
                    description="Pastikan data sudah benar sebelum mengirim."
                    :event="onSubmit"
                />
            </form>
        </main>
    </HomeLayout>
</template>
