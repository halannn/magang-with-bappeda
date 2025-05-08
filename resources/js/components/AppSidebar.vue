<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookCheckIcon, BookOpen, CalendarPlus2Icon, Clock, Folder, FoldersIcon } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import NavGroup from './NavGroup.vue';

const groupNavItems: NavItem[] = [
    {
        title: 'Absensi',
        href: '/dashboard/absensi',
        icon: Clock,
        children: [
            {
                title: 'Izin atau sakit',
                href: '/dashboard/absensi/izin-sakit',
            },
            {
                title: 'Riwayat',
                href: '/dashboard/absensi/riwayat',
            },
        ],
    },
    {
        title: 'Laporan kegiatan',
        href: '/dashboard/laporan-kegiatan',
        icon: CalendarPlus2Icon,
    },
    {
        title: 'Dokumen',
        href: '/dashboard/dokumen',
        icon: FoldersIcon,
    },
    {
        title: 'Sertifikat',
        href: '/dashboard/sertifikat',
        icon: BookCheckIcon,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard.index')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavGroup label="Mahasiswa" :items="groupNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
