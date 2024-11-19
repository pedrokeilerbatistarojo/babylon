<template>
  <q-select
    color="dark"
    :options="options"
    outlined
    dense
    :disable="disable"
    v-model="textValue"
    emit-value
    map-options
    lazy-rules
  />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  disable: {
    type: Boolean,
    default: false,
  },
  options: {
    type: Array,
    default: () => [],
    validator: (val) =>
      val.every(
        opt => typeof opt === 'object' && 'label' in opt && 'value' in opt
      ),
  }
});

const emit = defineEmits(['update:modelValue']);

const textValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>
