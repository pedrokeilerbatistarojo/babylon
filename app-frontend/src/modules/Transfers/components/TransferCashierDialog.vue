<template>
  <q-dialog
    full-width
  >
    <q-card>
      <q-card-section class="flex justify-between q-py-none bg-dark q-pa-md">
        <div class="text-h6 fw-bold text-accent">Transferir caja</div>
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
      <q-card-section class="q-pt-sm">
        <TransferForm
          @success="$emit('success')"
          @cancel="$emit('cancel')"
        />
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script setup>

import TransferForm from "src/modules/Transfers/components/TransferForm.vue";

// const props = defineProps({
//   company: Object,
// });

const emit  = defineEmits([
  'success',
  'cancel',
]);

</script>
