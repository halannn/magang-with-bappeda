<script setup lang="ts">
import FeatureCard from './FeatureCard.vue';

defineProps<{
  contents: {
    icon: any;
    title: string;
    description: string;
  }[];
}>();
</script>

<template>
  <div id="timeline_card" class="flex flex-col gap-5">
    <div class="relative flex h-10 w-full">
      <div class="absolute top-1/2 left-0 h-0.5 w-full -translate-y-1/2 transform bg-gray-300"></div>
      <div class="z-10 flex w-full flex-row items-center justify-between">
        <div v-for="(_, index) in contents" :key="index" class="flex w-full justify-center">
          <div class="h-4 w-4 rounded-full border-2 border-blue-900 bg-white"></div>
        </div>
      </div>
    </div>
    <div class="flex flex-row gap-5">
      <div v-for="(content, index) in contents" :key="index" class="flex w-full justify-center">
        <FeatureCard
          :icon="content.icon"
          :title="content.title"
          :description="content.description"
          class="flex w-full flex-col gap-4 rounded-2xl p-4 shadow"
        />
      </div>
    </div>
  </div>
</template>
