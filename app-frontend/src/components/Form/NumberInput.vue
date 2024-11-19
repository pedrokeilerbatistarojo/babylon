<template>
  <q-input
    v-model="textValue"
    outlined
    dense
    type="number"
    lazy-rules
    step="any" />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
});

const emit = defineEmits(['update:modelValue']);

const textValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', Number(value)),
});
</script>
