<template>
  <div class="q-gutter-sm row justify-around">
    <q-btn
      size="lg"
      v-for="amount in amounts"
      :key="amount"
      :label="`$${amount}`"
      color="accent"
      text-color="dark"
      push
      @click="emitAmount(amount)"
    />
  </div>
</template>

<script setup>
import { defineEmits } from 'vue';

const amounts = [100, 200, 500, 1000];
const emit = defineEmits(['amountSelected']);

const emitAmount = (amount) => {
  emit('amountSelected', amount);
};
</script>

<style scoped>

</style>
