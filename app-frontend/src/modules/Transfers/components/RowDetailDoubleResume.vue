<template>
  <div class="row items-center">
    <div class="col">
      <div :class="bolderTitle ? `fw-bold`: `text-normal`">{{props.title}}</div>
    </div>
    <div class="col">
      <div class="flex">
        <div class="q-mr-md">{{props.currency}}</div>
        <div class="q-mr-md fw-bold">{{props.amount}}</div>
      </div>
      <q-separator></q-separator>
      <div class="flex">
        <div class="q-mr-md">{{props.currencySecondary}}</div>
        <div class="q-mr-md fw-bold">{{props.amountSecondary}}</div>
        <div>{{props.converted}}</div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  bolderTitle: Boolean,
  title: String,
  currency: String,
  amount: String,
  currencySecondary: String,
  amountSecondary: String,
  converted: String
});
</script>
<style scoped>

</style>
