<script setup lang="ts">
import HomeLayout from '@/layouts/HomeLayout.vue';
</script>

<template>
    <Head title="Pemberitahuan" />
    <HomeLayout>
        <main class="mt-18 flex flex-col">
            <div class="bg-muted flex flex-col justify-center items-center gap-6 p-4 md:p-10 lg:p-20">
                <img src="/undraw_done-checking.svg" alt="" class="h-96"/>
                Silahkan cek email anda secara berkala untuk informasi verifikasi pendaftaran magang anda.
            </div>
        </main>
    </HomeLayout>
</template>
