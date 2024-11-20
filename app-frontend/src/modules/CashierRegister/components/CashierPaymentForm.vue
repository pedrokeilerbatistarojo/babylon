<template>
  <div class="q-pa-lg">
    <div class="font-size-16 text-uppercase fw-bold text-dark text-center q-mb-md">
      Seleccionar método de pago
    </div>
    <div class="row items-start">
      <div class="col q-pa-md text-center">
        <q-img
          alt="mxn Image"
          src="~assets/payment-methods/mxn.png"
          class="img-payment"
          @click="handleSelectMethod('MXN')"
        />
        <span class="block q-mt-sm text-payment" @click="handleSelectMethod('mxn')">MXN </span>
      </div>
      <div class="col q-pa-md text-center">
        <q-img
          alt="usd Image"
          src="~assets/payment-methods/usd.png"
          class="img-payment"
          @click="handleSelectMethod('USD')"
        />
        <span class="block q-mt-sm text-payment" @click="handleSelectMethod('usd')">USD</span>
      </div>
      <div class="col q-pa-md text-center">
        <q-img
          alt="debit Image"
          src="~assets/payment-methods/debit.png"
          class="img-payment"
        />
        <span class="block q-mt-sm text-payment">Tarjeta de débito</span>
      </div>
      <div class="col q-pa-md text-center">
        <q-img
          alt="credit Image"
          src="~assets/payment-methods/credit-2.png"
          class="img-payment"
        />
        <span class="block q-mt-sm text-payment">Tarjeta de crédito</span>
      </div>
    </div>
    <div
      v-if="methodVisibility"
      class="row q-pt-md items-center justify-center"
    >
      <div class="col-12 flex justify-between">
        <p class="font-size-16">Método de pago: </p>
        <p class="fw-bold font-size-16">{{form.method}}</p>
      </div>
      <div class="col-12 flex justify-between">
        <p class="font-size-16">A pagar: </p>
        <p class="fw-bold font-size-16">$ {{total}}</p>
      </div>
      <div class="col-12 flex justify-between">
        <p class="font-size-16">Faltante: </p>
        <p class="fw-bold font-size-16">$ {{form.missing}}</p>
      </div>
      <div class="col-12 flex justify-between">
        <p class="font-size-16">Recibido:</p>
        <NumberInput
          style="width: 160px"
          input-class="text-right fw-bold font-size-16"
          v-model="form.receive"
          label="Monto Recibido"
          :rules="[(val) => InputValidationService.required(val)]"
          @update:modelValue="handleReceiveChange"
        />
      </div>
    </div>
    <div
      v-if="methodVisibility"
      class="row q-pt-md items-center justify-center"
    >
      <ShortcutMoney @amount-selected="handleSelected" />
    </div>
  </div>
  <div class="row q-mt-md bg-mor q-pa-md">
    <div class="col flex justify-between">
      <q-btn color="negative" label="Cancelar" @click="$emit('cancel')" class="fw-bold" />
      <q-btn color="accent" :disabled="!isValidConfirm" text-color="dark" label="Confirmar Pago" @click="handleConfirm" class="fw-bold" />
    </div>
  </div>
</template>

<script setup>

import {computed, reactive, ref, watch} from "vue";
import CashierService from "src/modules/CashierRegister/services/CashierService";
import NumberInput from "components/Form/NumberInput.vue";
import InputValidationService from "src/services/InputValidationService";
import ShortcutMoney from "src/modules/CashierRegister/components/ShortcutMoney.vue";

const props = defineProps({
  cart: Object
});

const emit  = defineEmits([
  'success',
  'cancel',
]);

const methodVisibility = ref(false);
const isValidConfirm = ref(false);

const total = computed(() => CashierService.getCashierCartTotal(props.cart));

const form = reactive({
  missing: 0,
  receive: null,
  total: total.value,
  method: null,
});

const handleSelectMethod = (type) => {
  form.method = type;
  methodVisibility.value = true;
}

const handleReceiveChange = (value) => {
  form.missing = total.value - value;
}

const handleSelected = (amount) => {
  form.receive = amount;
  form.missing = total.value - amount;
}

watch(form, (newValue)=>{
  isValidConfirm.value = newValue.receive > 0;
}, {deep: true});

</script>

<style scoped>
.img-payment{
  cursor: pointer;
  width: 40px;
}

.img-payment :hover{
  cursor: pointer;
  padding: 4px;
}

.text-payment{
  cursor: pointer;
}

.text-payment :hover{
  padding: 2px;
  font-weight: bold!important;
  font-size: 16px;
}
</style>
