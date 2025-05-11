<script setup lang="ts">
import { ArrowRight } from 'lucide-vue-next';
import Button from './ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    caption: {
        type: String,
        required: false,
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: false,
    },
    button: {
        type: Boolean,
        required: true,
    },
    buttonText: {
        type: String,
        required: false,
    },
    buttonLink: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <div id="hero" class="flex w-full flex-col justify-center gap-10">
        <div id="text" class="flex flex-col gap-2 md:gap-6">
            <p class="md:text-xl font-bold text-blue-900" v-if="caption">{{ caption }}</p>
            <p class="text-xl md:text-4xl font-bold" v-html="title"></p>
            <p class="md:text-lg" v-html="description"></p>
        </div>
        <div id="cta" v-if="button">
            <Link :href="buttonLink" class="inline-block px-2 py-3">
                <Button v size="lg" class="bg-blue-900 font-medium text-gray-50 hover:bg-gray-900">
                    {{ buttonText }}
                    <ArrowRight />
                </Button>
            </Link>
        </div>
    </div>
</template>
