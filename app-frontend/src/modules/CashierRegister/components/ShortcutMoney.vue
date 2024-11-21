<template>
  <div class="row justify-between">
    <q-btn
      v-for="(obj, index) in amounts"
      :key="index"
      :label="`${obj.currency} $ ${obj.amount}`"
      color="info"
      text-color="dark"
      push
      @click="emitAmount(obj.amount)"
    />
  </div>
</template>

<script setup>
import {computed, defineEmits} from 'vue';
import cashierService from "src/modules/CashierRegister/services/CashierService";

const props = defineProps({
  type: String
});

const amounts = computed(() => cashierService.getListShortcutAmounts(props.type));
const emit = defineEmits(['amountSelected']);

const emitAmount = (amount) => {
  emit('amountSelected', amount);
};
</script>

<style scoped>

</style>
