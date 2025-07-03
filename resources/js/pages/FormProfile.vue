<script setup lang="ts">
import Alert from '@/components/Alert.vue';
import TextContainer from '@/components/TextContainer.vue';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import HomeLayout from '@/layouts/HomeLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { toast } from 'vue-sonner';
import * as z from 'zod';

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
            .refine((file) => ACCEPTED_IMAGE_TYPES.includes(file?.type), 'Hanya format .jpg, .jpeg, .png dan .webp yang didukung.'),
        cv_pribadi: z
            .any()
            .refine((file) => file instanceof File, 'File diperlukan')
            .refine((file) => file?.size < MAX_FILE_SIZE, 'Ukuran maksimal file 2MB.')
            .refine((file) => checkFileType(file), 'Hanya format .pdf yang didukung.'),
    }),
);

const form = useForm({ validationSchema: formSchema });

const onSubmit = form.handleSubmit((values) => {
    console.log('Form submitted!', values);

    router.post(route('pendaftaran.profile.store'), values, {
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
    <Head title="Form Profile" />
    <HomeLayout>
        <main class="mt-18 flex flex-col gap-6 p-4 md:p-10 lg:p-20">
            <TextContainer title="Form profile" description="Silahkan mengisi keterangan pribadi anda." :button="false" />
            <form @submit.prevent class="flex flex-col gap-6">
                <FormField v-slot="{ componentField }" name="nama_lengkap">
                    <FormItem>
                        <FormLabel>Nama lengkap</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nama lengkap sesuai kartu identitas. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="nomor_mahasiswa">
                    <FormItem>
                        <FormLabel>Nomor mahasiswa</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nomor Induk Mahasiswa (NIM) anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="asal_kampus">
                    <FormItem>
                        <FormLabel>Asal kampus</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nama dari kampus anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="fakultas">
                    <FormItem>
                        <FormLabel>Fakultas</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nama dari fakultas anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="jurusan">
                    <FormItem>
                        <FormLabel>Jurusan</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nama dari kampus anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="program_studi">
                    <FormItem>
                        <FormLabel>Program studi</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nama dari program studi anda. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="kontak">
                    <FormItem>
                        <FormLabel>Kontak</FormLabel>
                        <FormControl>
                            <Input type="text" v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Nomor (WA) aktif yang bisa dihubungi. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField }" name="deskripsi_diri">
                    <FormItem>
                        <FormLabel>Deskripsi diri</FormLabel>
                        <FormControl>
                            <Textarea v-bind="componentField" />
                        </FormControl>
                        <FormDescription> Jelaskan diri anda secara singkat. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="foto_profile">
                    <FormItem>
                        <FormLabel>Foto profile</FormLabel>
                        <FormControl>
                            <Input type="file" accept="ACCEPTED_IMAGE_TYPES" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
                        </FormControl>
                        <FormDescription> Upload gambar dengan rasio 1:1. </FormDescription>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <FormField v-slot="{ componentField: field }" name="cv_pribadi">
                    <FormItem>
                        <FormLabel>CV</FormLabel>
                        <FormControl>
                            <Input type="file" accept=".pdf" @change="(e: any) => field.onChange(e.target.files?.[0] ?? null)" />
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
