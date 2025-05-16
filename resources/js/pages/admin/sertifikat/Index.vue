<script setup lang="ts">
import { usePagination } from '@/composables/usePagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, SertifikatItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
    },
    {
        title: 'Sertifikat',
        href: '/admin/dashboard/sertifikat',
    },
];

const {
    items: sertifikat,
    currentPage,
    lastPage,
    links,
    goTo,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
} = usePagination<SertifikatItem>('sertifikat');
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs"> </AppLayout>
</template>
