<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <AuthLayout
        title="Verifikasi Email"
        description="Silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email."
    >
        <Head title="Verifikasi Email" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat mendaftar.
        </div>

        <form @submit.prevent="submit" class="space-y-6 text-center">
            <Button :disabled="form.processing" variant="default">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Kirim Ulang Email Verifikasi
            </Button>

            <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm"> Keluar </TextLink>
        </form>
    </AuthLayout>
</template>
