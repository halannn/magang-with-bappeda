<script setup lang="ts">
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'

const defaultValue = 'item-1'

const accordionItems = [
  {
    value: 'item-1',
    title: 'Bagaimana proses pendaftaran?',
    content: 'Mahasiswa dapat mendaftar melalui halaman pendaftaran di website. Setelah mengisi formulir dan mengunggah dokumen, pendaftaran akan diverifikasi oleh admin.'
  },
  {
    value: 'item-2',
    title: 'Apakah bisa magang jarak jauh?',
    content: 'Saat ini, program magang hanya tersedia secara tatap muka di kantor BAPPEDA Litbang Balikpapan.'
  },
  {
    value: 'item-3',
    title: 'Siapa saja yang bisa mendaftar?',
    content: 'Program ini terbuka bagi mahasiswa aktif dari berbagai jurusan yang berminat dalam bidang perencanaan pembangunan daerah.'
  },
  {
    value: 'item-4',
    title: 'Apa saja berkas yang dibutuhkan?',
    content: 'Mahasiswa perlu menyiapkan CV, surat pengantar dari kampus, dan transkrip nilai (jika diperlukan) untuk keperluan verifikasi.'
  }
]

</script>

<template>
  <Accordion type="single" class="w-full" collapsible :default-value="defaultValue">
    <AccordionItem v-for="item in accordionItems" :key="item.value" :value="item.value" class=" bg-background mt-4 p-2 rounded">
      <AccordionTrigger class="text-primary">{{ item.title }}</AccordionTrigger>
      <AccordionContent>
        {{ item.content }}
      </AccordionContent>
    </AccordionItem>
  </Accordion>
</template>