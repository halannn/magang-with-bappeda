<script setup lang="ts">
defineProps({
  costumStyle: {
    type: String,
    required: true,
    default: '',
  },
  icon: {
    type: Object,
    required: true,
  },
  iconColor: {
    type: String,
    required: true,
    default: '#233876',
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
      <component :is="icon" :size="40" :color="iconColor" />
    </div>
    <div class="flex flex-col gap-1">
      <p class="text-xl font-bold">{{ title }}</p>
      <p class="font-medium text-gray-500">{{ description }}</p>
    </div>
  </div>
</template>
