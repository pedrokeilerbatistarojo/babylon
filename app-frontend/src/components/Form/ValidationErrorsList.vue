<template>
  <div class="q-mb-sm">
    <q-banner
      v-if="errorMessages.length"
      class="bg-red text-white"
      icon="info"
      inline-actions
    >
      <div v-for="(message, index) in errorMessages" :key="index">
        <span class="block">{{ message }}</span>
      </div>
    </q-banner>
  </div>
</template>

<script setup>

import {computed, watch} from "vue";

const props = defineProps({
  errors: Object
});

const errorMessages = computed(() => {
  const errors = props.errors;

  return errors
    ? Object.values(errors).flat()
    : [];
});

watch(props, (newVal) => {
  console.log(newVal);
});

</script>
