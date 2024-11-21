<template>
  <q-dialog
  >
    <q-card class="gradient-border shadow-10" style="width: 500px;">
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
      <q-card-section class="q-pa-none bg-dark">
        <CashierPaymentForm
          :cart="props.cart"
          :payment-method="props.paymentMethod"
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
  paymentMethod: String
});

const emit  = defineEmits([
  'success',
  'cancel',
]);

</script>
