<script setup lang="ts">
import { Instagram, Linkedin } from 'lucide-vue-next';

defineProps<{
  testimonial: {
    image: string;
    nama: string;
    kampus: string;
    bodyText: string;
    sosmed?: {
      instagram: string;
      linkedin: string;
    };
  }[];
}>();
</script>

<template>
  <div id="card_testimonial" class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div v-for="(item, index) in testimonial" :key="index" class="flex w-full flex-col gap-4 rounded-2xl p-4 shadow">
      <div id="head" class="w-full">
        <img :src="item.image" alt="" class="h-60 w-full rounded-2xl object-cover" />
      </div>
      <div id="body" class="flex h-full flex-col gap-3">
        <div id="title">
          <p class="text-xl font-bold">{{ item.nama }}</p>
          <p class="text-sm md:text-base font-medium text-muted-foreground">{{ item.kampus }}</p>
        </div>
        <p id="content" class="h-full">{{ item.bodyText }}</p>
      </div>
      <div id="sosmed" class="m-0 flex flex-row gap-2 p-0" v-if="item.sosmed">
        <a :href="item.sosmed.instagram" target="_blank" rel="noopener noreferrer" class="m-0 p-0">
          <Instagram />
        </a>
        <a :href="item.sosmed.linkedin" target="_blank" rel="noopener noreferrer" class="m-0 p-0">
          <Linkedin />
        </a>
      </div>
    </div>
  </div>
</template>
