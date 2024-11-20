<template>
  <q-dialog
  >
    <q-card>
      <q-card-section class="flex justify-between q-py-none bg-mor q-pa-md">
        <div class="text-h6 fw-bold text-accent">Pagar</div>
        <div>
          <q-btn
            class="q-pa-none"
            flat
            icon="close"
            text-color="accent"
            @click="$emit('cancel')"
          />
        </div>
      </q-card-section>
      <q-separator />
      <q-card-section class="q-pa-none">
        <CashierPaymentForm
          :cart="props.cart"
          @success="$emit('success')"
          @cancel="$emit('cancel')"
        />
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script setup>

import CashierPaymentForm from "src/modules/CashierRegister/components/CashierPaymentForm.vue";

const props = defineProps({
  cart: Object,
});

const emit  = defineEmits([
  'success',
  'cancel',
]);

</script>
