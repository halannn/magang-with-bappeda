<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';
import Button from './ui/button/Button.vue';

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
    <div id="hero" class="flex w-full flex-col justify-center gap-4 md:gap-10">
        <div id="text" class="flex flex-col gap-4">
            <p class="text-primary font-bold md:text-xl" v-if="caption">{{ caption }}</p>
            <p class="text-2xl font-bold md:text-2xl" v-html="title"></p>
            <p class="md:text-lg" v-if="description" v-html="description"></p>
        </div>
        <div id="cta" v-if="button">
            <Link :href="buttonLink">
                <Button size="default" md:size="lg" variant="default">
                    {{ buttonText }}
                    <ArrowRight />
                </Button>
            </Link>
        </div>
    </div>
</template>
