<script setup lang="ts">
import Alert from '@/components/Alert.vue';
import TextContainer from '@/components/TextContainer.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { FormControl, FormField, FormItem, FormLabel } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { Auth, Verifikasi, type BreadcrumbItem } from '@/types';
import type { PageProps } from '@inertiajs/core';
import { Head, router, usePage } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
import { toTypedSchema } from '@vee-validate/zod';
import { CalendarIcon } from 'lucide-vue-next';
import { toDate } from 'reka-ui/date';
import { useForm } from 'vee-validate';
import { computed, onMounted, ref } from 'vue';
import * as z from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Verifkasi mahasiswa',
        href: '/admin/dashboard/verifikasi',
    },
    {
        title: 'Detail mahasiswa',
        href: '/admin/dashboard/pendaftar',
    },
];

interface Props extends PageProps {
    verifikasi: Verifikasi;
    auth: Auth;
    errors: Record<string, string>;
}

const page = usePage<Props>();
const { verifikasi, auth, errors } = page.props;

const MAX_FILE_SIZE = 2 * 1024 * 1024;
const ACCEPTED_IMAGE_TYPES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

function checkFileType(file: File) {
    if (file?.name) {
        const fileType = file.name.split('.').pop();
        if (fileType === 'pdf') return true;
    }
    return false;
}

const formSchema = toTypedSchema(
    z.object({
        nama_lengkap: z.string().min(2).max(50),
        nomor_mahasiswa: z.string().min(2),
        asal_kampus: z.string().min(2),
        fakultas: z.string().min(2),
        jurusan: z.string().min(2),
        program_studi: z.string().min(2),
        deskripsi_diri: z.string().min(2),
        kontak: z.string().min(2),
        foto_profile: z
            .any()
            .refine((file) => file?.size <= MAX_FILE_SIZE, `Ukuran gambar maksimal 2MB.`)
            .refine((file) => ACCEPTED_IMAGE_TYPES.includes(file?.type), 'Hanya format .jpg, .jpeg, .png dan .webp yang didukung.')
            .optional(),
        cv_pribadi: z
            .any()
            .refine((file) => file instanceof File, 'File diperlukan')
            .refine((file) => file?.size < MAX_FILE_SIZE, 'Ukuran maksimal file 2MB.')
            .refine((file) => checkFileType(file), 'Hanya format .pdf yang didukung.')
            .optional(),
        posisi_magang: z.string().min(2).max(50),
        deskripsi_magang: z.string().min(2),
        tanggal_mulai: z.string().nonempty('Tanggal harus diisi.'),
        tanggal_selesai: z.string().nonempty('Tanggal harus diisi.'),
        surat_magang: z
            .any()
            .refine((file) => file instanceof File, 'File diperlukan')
            .refine((file) => file?.size < MAX_FILE_SIZE, 'Ukuran maksimal file 2MB.')
            .refine((file) => checkFileType(file), 'Hanya format .pdf yang didukung.')
            .optional(),
        bidang_magang: z.string().min(2),
        status_magang: z.string().min(2),
    }),
);

const form = useForm({
    validationSchema: formSchema,
    initialValues: {},
});
const { handleSubmit, setFieldValue, values } = form;

const placeholder = ref();
const df = new DateFormatter('id-ID', {
    dateStyle: 'full',
});

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

    const profile_id = verifikasi.profile.id;

    router.post(
        route('admin.dashboard.verifikasi.update', profile_id),
        {
            _method: 'put',
            bidang_magang: values.bidang_magang,
            status_magang: values.status_magang,
        },
        {
            forceFormData: true,
        },
    );
});

onMounted(() => {
    setFieldValue('nama_lengkap', verifikasi.profile.nama_lengkap);
    setFieldValue('nomor_mahasiswa', verifikasi.profile.nomor_mahasiswa);
    setFieldValue('asal_kampus', verifikasi.profile.asal_kampus);
    setFieldValue('fakultas', verifikasi.profile.fakultas);
    setFieldValue('jurusan', verifikasi.profile.jurusan);
    setFieldValue('program_studi', verifikasi.profile.program_studi);
    setFieldValue('kontak', verifikasi.profile.kontak);
    setFieldValue('deskripsi_diri', verifikasi.profile.deskripsi_diri);
    setFieldValue('posisi_magang', verifikasi.posisi_magang);
    setFieldValue('deskripsi_magang', verifikasi.deskripsi_magang);
    setFieldValue('tanggal_mulai', verifikasi.tanggal_mulai);
    setFieldValue('tanggal_selesai', verifikasi.tanggal_selesai);
    setFieldValue('bidang_magang', verifikasi.profile.bidang_magang);
    setFieldValue('status_magang', verifikasi.profile.status_magang);
});
</script>

<template>
    <Head title="Form Profile" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <main class="flex h-full flex-1 flex-col items-center justify-center gap-4 rounded-xl p-4">
            <form @submit="onSubmit" class="w-9/10 space-y-8">
                <TextContainer title="Keterangan profile" :button="false" />
                <FormField v-slot="{ componentField }" name="nama_lengkap">
                    <FormItem>
                        <FormLabel>Nama lengkap</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="nomor_mahasiswa">
                    <FormItem>
                        <FormLabel>Nomor mahasiswa</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="fakultas">
                    <FormItem>
                        <FormLabel>Asal kampus</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="fakultas">
                    <FormItem>
                        <FormLabel>Fakultas</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="jurusan">
                    <FormItem>
                        <FormLabel>Jurusan</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="program_studi">
                    <FormItem>
                        <FormLabel>Program studi</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="kontak">
                    <FormItem>
                        <FormLabel>Kontak</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_diri">
                    <FormItem>
                        <FormLabel>Deskripsi diri</FormLabel>
                        <FormControl>
                            <Textarea v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="foto_profile">
                    <FormItem>
                        <FormLabel>Foto profile</FormLabel>
                        <FormControl>
                            <a
                                v-if="verifikasi.profile.foto_profile"
                                class="text-sm underline"
                                :href="route('admin.dashboard.verifikasi.avatar', verifikasi.profile.foto_profile.split('/').pop())"
                            >
                                Lihat Proposal
                            </a>
                            <Input v-else type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="cv_pribadi">
                    <FormItem>
                        <FormLabel>CV</FormLabel>
                        <FormControl>
                            <a
                                v-if="verifikasi.profile.cv_pribadi"
                                class="text-sm underline"
                                :href="route('admin.dashboard.verifikasi.cv', verifikasi.profile.cv_pribadi.split('/').pop())"
                            >
                                Lihat Proposal
                            </a>
                            <Input v-else type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <TextContainer title="Keterangan magang" :button="false" />

                <FormField v-slot="{ componentField }" name="posisi_magang">
                    <FormItem>
                        <FormLabel>Posisi magang</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_magang">
                    <FormItem>
                        <FormLabel>Deskripsi magang</FormLabel>
                        <FormControl>
                            <Textarea v-bind="componentField" readonly />
                        </FormControl>
                    </FormItem>
                </FormField>

                <FormField name="tanggal_mulai">
                    <FormItem class="flex w-full flex-col">
                        <FormLabel>Tanggal mulai</FormLabel>
                        <Popover>
                            <PopoverTrigger as-child>
                                <FormControl>
                                    <Button
                                        variant="outline"
                                        disabled
                                        :class="cn('w-full ps-3 text-start font-normal', !value1 && 'text-muted-foreground')"
                                    >
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
                                    <Button
                                        variant="outline"
                                        disabled
                                        :class="cn('w-full ps-3 text-start font-normal', !value2 && 'text-muted-foreground')"
                                    >
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

                <FormField v-slot="{ componentField: field }" name="surat_magang">
                    <FormItem>
                        <FormLabel>Surat atau proposal magang</FormLabel>
                        <FormControl>
                            <a
                                v-if="verifikasi.surat_magang"
                                class="text-sm underline"
                                :href="route('admin.dashboard.verifikasi.proposal', verifikasi.surat_magang.split('/').pop())"
                            >
                                Lihat Proposal
                            </a>
                            <Input v-else type="file" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                    </FormItem>
                </FormField>

                <TextContainer title="Verifikasi status" :button="false" />
                <FormField v-slot="{ componentField }" name="bidang_magang">
                    <FormItem>
                        <FormLabel>Bidang magang</FormLabel>
                        <Select v-bind="componentField">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih bidang magang untuk mahasiswa" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="Seketariat"> Seketariat </SelectItem>
                                    <SelectItem value="Litbang"> Litbang </SelectItem>
                                    <SelectItem value="KRA"> KRA </SelectItem>
                                    <SelectItem value="PIPP"> PIPP </SelectItem>
                                    <SelectItem value="P3"> P3 </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="status_magang">
                    <FormItem>
                        <FormLabel>Status magang</FormLabel>
                        <Select v-bind="componentField">
                            <FormControl>
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Pilih status magang untuk mahasiswa" />
                                </SelectTrigger>
                            </FormControl>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="Aktif"> Aktif </SelectItem>
                                    <SelectItem value="Selesai"> Selesai </SelectItem>
                                    <SelectItem value="Dikeluarkan"> Dikeluarkan </SelectItem>
                                    <SelectItem value="Pending"> Pending </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </FormItem>
                </FormField>

                <div class="mt-10 flex flex-row justify-end-safe gap-5">
                    <a :href="route('admin.dashboard.verifikasi.index')">
                        <Button type="button" variant="secondary"> Kembali </Button>
                    </a>
                    <Alert
                        dialog="Konfirmasi"
                        title="Konfirmasi Pengiriman Data"
                        description="Pastikan data sudah benar sebelum mengirim."
                        :event="onSubmit"
                    />
                </div>
            </form>
        </main>
    </AppLayout>
</template>
