<script setup lang="ts">
import FeatureCard from './FeatureCard.vue';

const props = defineProps<{
    contents: {
        icon: any;
        title: string;
        description: string;
    }[];
}>();
</script>

<template>
    <div id="timeline_card" class="flex flex-col gap-5">
        <div class="relative hidden h-10 w-full lg:flex">
            <div class="bg-foreground absolute top-1/2 left-0 h-0.5 w-full -translate-y-1/2 transform"></div>
            <div class="z-10 flex w-full flex-row items-center justify-between">
                <div v-for="(_, index) in contents" :key="index" class="flex w-full justify-center">
                    <div class="border-foreground bg-background h-4 w-4 rounded-full border-2"></div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-5 lg:flex-row">
            <div v-for="(content, index) in contents" :key="index" class="w-full">
                <FeatureCard :icon="content.icon" :title="content.title" :description="content.description" costumStyle="" />
            </div>
        </div>
    </div>
</template>
