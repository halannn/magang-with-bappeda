<script setup lang="ts">
defineProps({
    costumStyle: {
        type: String,
        required: true,
        default: 'text-foreground flex flex-row items-center gap-4 rounded-2xl bg-background px-5 py-5',
    },
    icon: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: false,
    },
    description: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div :class="costumStyle">
        <div>
            <component :is="icon" :size="40" />
        </div>
        <div class="flex flex-col gap-1">
            <p class="text-lg font-bold lg:text-xl">{{ title }}</p>
            <p class="text-sm md:text-base">{{ description }}</p>
        </div>
    </div>
</template>
