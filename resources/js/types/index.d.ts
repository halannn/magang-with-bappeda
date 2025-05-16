import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    children?: NavItem[];
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

interface Pagination {
    current_page: number;
    last_page: number;
    next_page_url: string;
    prev_page_url: string;
    first_page_url: string;
    last_page_url: string;
    links: any;
}

interface User {
    id: number;
    name: string;
    email: string;
    status: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}
interface Profile {
    id: number;
    user: User;
    nama_lengkap: string;
    nomor_mahasiswa: string;
    asal_kampus: string;
    fakultas: string;
    jurusan: string;
    program_studi: string;
    deskripsi_diri: string;
    kontak: string;
    foto_profile: string | undefined;
    cv_pribadi: string | undefined;
    bidang_magang: string | undefined;
    status_magang: string;
}
interface Verifikasi {
    id: number;
    user: Auth;
    profile: Profile;
    posisi_magang: string;
    deskripsi_magang: string;
    tanggal_mulai: string;
    tanggal_selesai: string;
    surat_magang: string | undefined;
}

interface Absen {
    id: number;
    profile: Profile;
    keterangan: string;
    status: string;
    tanggal: string | Date;
    waktu_datang: string;
    waktu_pulang: string;
    surat: string;
    verifikasi: string;
}

interface Dokumen {
    id: number;
    profile_id: number;
    deskripsi_dokumen: string;
    tanggal: string;
    file: string | undefined;
}
interface Laporan {
    id: number;
    profile: Profile;
    tanggal: string;
    deskripsi_kegiatan: string;
    hasil: string;
    waktu: string;
    dokumentasi?: string | undefined;
}

interface Sertifikat {
    id: number;
    profile: Profile;
    tanggal_terbit: string | Date;
    file: string;
}

export interface ProfileItem extends Pagination {
    data: Profile[];
}
export interface VerifikasiItem extends Pagination {
    data: Verifikasi[];
}
export interface AbsenItem extends Pagination {
    data: Absen[];
}
export interface LaporanItem extends Pagination {
    data: Laporan[];
}
export interface DokumenItem extends Pagination {
    data: Dokumen[];
}
export interface SertifikatItem extends Pagination {
    data: Sertifikat[];
}

export type BreadcrumbItemType = BreadcrumbItem;
