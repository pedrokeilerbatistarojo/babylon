<template>
  <q-input
    color="dark"
    outlined
    dense
    :disable="disable"
    v-model="textValue"
    type="text"
    lazy-rules />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  disable: {
    type: Boolean,
    default: false,
  }
});

const emit = defineEmits(['update:modelValue']);

const textValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>
