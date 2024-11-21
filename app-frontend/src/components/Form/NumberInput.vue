<template>
  <q-input
    v-model="textValue"
    outlined
    dense
    type="number"
    lazy-rules
    step="any"
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
  set: (value) => emit('update:modelValue', Number(value)),
});
</script>

<style>
.q-field--outlined .q-field__control::before {
  border: 1px solid var(--q-accent)!important;
}

.custom-border .q-field {
  border: 1px solid!important;
  border-color: var(--q-accent)!important;
}

.custom-border .q-field--focused {
  border-color: var(--q-accent)!important;
}
</style>
