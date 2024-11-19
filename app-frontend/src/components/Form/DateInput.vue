<template>
  <q-input
    outlined
    v-model="textValue"
    clearable
    dense
    type="date"
    lazy-rules
  />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
});

const emit = defineEmits(['update:modelValue']);

const textValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>
