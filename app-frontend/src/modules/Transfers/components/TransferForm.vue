<template>
<div class="q-py-sm">
  <div class="row">
    <div class="col-12 col-sm-6 q-pa-md bg-soft">
      <TransferResume :transfer="null" />
    </div>
    <div class="col-12 col-sm-6 q-pa-md bg-soft">
      <p class="font-size-16 text-center fw-bold text-dark">Montos a Transferir</p>
      <div class="row q-col-gutter-md">
        <div class="col">
          <TextInput
            v-model="form.amount_mxn"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Efectivo MXN *"
          />
        </div>
        <div class="col">
          <TextInput
            v-model="form.amount_usd"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Efectivo USD"
          />
        </div>
        <div class="col">
          <TextInput
            v-model="form.card_amount_mxn"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Tarjeta MXN"
          />
        </div>
      </div>

      <TransferNumericKeypad />

      <p class="font-size-16 text-center fw-bold text-dark">Faltantes</p>
      <div class="row q-col-gutter-md">
        <div class="col">
          <TextInput
            v-model="form.missing_amount_mxn"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Efectivo MXN *"
          />
        </div>
        <div class="col">
          <TextInput
            v-model="form.missing_amount_usd"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Efectivo USD"
          />
        </div>
        <div class="col">
          <TextInput
            v-model="form.missing_card_amount_mxn"
            input-class="text-right"
            mask="#,###,###,###.##"
            reverse-fill-mask
            :rules="[(val) => InputValidationService.required(val)]"
            label="Tarjeta MXN"
          />
        </div>
      </div>
      <div class="row items-center q-col-gutter-md">
        <div class="col-4">
          <span class="fw-bold">Transferir a Usuario:</span>
        </div>
        <div class="col-8">
          <SelectInput
            :options="userOptions"
            label="Seleccione un usuario"
            class="full-width"
          />
        </div>
      </div>
      <div class="row justify-between q-mt-lg">
        <q-btn color="negative" label="Cancelar" @click="$emit('cancel')" class="fw-bold" />
        <q-btn color="accent" text-color="dark" label="Confirmar" @click="handleConfirm" class="fw-bold" />
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
import TransferResume from "src/modules/Transfers/components/TransferResume.vue";
import InputValidationService from "src/services/InputValidationService";
import TextInput from "components/Form/TextInput.vue";
import {computed, reactive} from "vue";
import SelectInput from "components/Form/SelectInput.vue";
import TransferNumericKeypad from "src/modules/Transfers/components/TransferNumericKeypad.vue";

const form = reactive({
  amount_mxn: 0,
  amount_usd: 0,
  card_amount_mxn: 0,
  missing_amount_mxn: 0,
  missing_amount_usd: 0,
  missing_card_amount_mxn: 0,
});

const userOptions = computed(() => [
]);

const emit  = defineEmits([
  'success',
  'cancel',
]);

</script>

<style scoped>

</style>
