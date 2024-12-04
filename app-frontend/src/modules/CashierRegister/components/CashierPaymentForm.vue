<template>
  <div class="q-py-sm">
    <div class="row q-pt-md items-center justify-center text-accent">
      <div class="col-4 text-center font-size-16">
        <span class="block text-uppercase">Por pagar </span>
        <span class="block">MXN</span>
        <q-badge size="lg" color="blue" class="q-mt-sm">
          <span class="fw-bold block font-size-16 q-pa-sm">
          $ {{total}}
          </span>
        </q-badge>
      </div>
<!--      <div v-if="form.method === `USD`" class="col-4 flex justify-between">-->
<!--        <p class="font-size-16">Referencia USD: </p>-->
<!--        <p class="fw-bold font-size-16">USD $ {{form.reference_usd}}</p>-->
<!--      </div>-->
      <div class="col-4 text-center font-size-16">
        <span class="block text-uppercase">Faltante </span>
        <span class="block">MXN</span>
        <q-badge size="lg" color="blue" class="q-mt-sm">
          <span class="fw-bold block font-size-16 q-pa-sm">
          $ {{form.missing}}
          </span>
        </q-badge>
      </div>
      <div class="col-4 text-center font-size-16">
        <span class="block text-uppercase">Cambio </span>
        <span class="block">MXN</span>
        <q-badge size="lg" color="blue" class="q-mt-sm">
          <span class="fw-bold block font-size-16 q-pa-sm">
          $ {{form.return}}
          </span>
        </q-badge>
      </div>
    </div>
    <div class="row q-pt-md items-center justify-center text-accent">
      <div class="col-12 flex justify-between q-mt-md">
        <p class="font-size-16">Monto Recibido:</p>
        <NumberInput
          style="width: 100px;"
          input-class="text-right fw-bold font-size-16"
          text-color="accent"
          color="accent"
          v-model="form.receive"
          placeholder="Recibido"
          @update:modelValue="handleReceiveChange"
        />
      </div>
    </div>
    <div class="q-pt-lg row">
      <div class="col-4">
        <ShortcutMoney
          :type="form.method"
          @amount-selected="handleSelected"
        />
      </div>
      <div class="col-8"></div>
    </div>
  </div>
  <div class="row q-mt-md bg-mor q-pa-md">
    <div class="col flex justify-between">
      <q-btn color="negative" label="Cancelar" @click="$emit('cancel')" class="fw-bold" />
      <q-btn
        class="fw-bold"
        color="accent"
        text-color="dark"
        :loading="loading"
        :disabled="!isValidConfirm"
        label="Cobrar"
        @click="handleConfirm" />
    </div>
  </div>
</template>

<script setup>

import {computed, onMounted, reactive, ref, watch} from "vue";
import CashierService from "src/modules/CashierRegister/services/CashierService";
import NumberInput from "components/Form/NumberInput.vue";
import ShortcutMoney from "src/modules/CashierRegister/components/ShortcutMoney.vue";
import {useExchangeStore} from "src/modules/CashierRegister/stores/exchange";
import {storeToRefs} from "pinia";

const props = defineProps({
  cart: Object,
  paymentMethod: String
});

const emit  = defineEmits([
  'success',
  'cancel',
]);

const isValidConfirm = ref(false);

const { fetchExchangeRate } = useExchangeStore();
const { exchange, loading } = storeToRefs(useExchangeStore());

const total = computed(() => CashierService.getCashierCartTotal(props.cart));
const exchangeRateMxn = computed(() => Math.round(exchange.value.conversion_rates.MXN));

const form = reactive({
  missing: 0,
  receive: null,
  total: total.value,
  method: props.paymentMethod ?? null,
  reference_usd: 0,
  return: 0
});

const handleReceiveChange = (amount) => {
  form.return = 0;
  form.missing = 0;
  calcChargeData(amount);
}

const handleSelected = (amount) => {
  form.return = 0;
  form.missing = 0;
  form.receive = amount;
  calcChargeData(amount);
}

onMounted(() => {
  if(form.method === 'USD'){
    if (exchange.value === null){
      fetchExchangeRate().then(() => {
        if (exchange.value !== null) {
          calcExchangeRate(exchange.value);
        }
      }).catch(error => {
        console.error('Error al obtener la tasa de cambio:', error);
      });
    }else{
      calcExchangeRate(exchange.value);
    }
  }
});

watch(form, (newValue)=>{
  isValidConfirm.value = newValue.receive > 0;

  if(newValue.method === 'USD'){
    if (exchange.value !== null){
      calcExchangeRate(exchange.value);
    }
  } else if(newValue.method === 'DEBIT' || newValue.method === 'CREDIT BANK'){
    isValidConfirm.value = newValue.receive === total.value;
  }
}, {deep: true});

watch(props, (newValue)=>{
  if(newValue.paymentMethod === 'USD'){
    if (exchange.value !== null){
      calcExchangeRate(exchange.value);
    }
  }
}, {deep: true});

const calcExchangeRate = (exchange) => {
  const conversion_rate = exchange.conversion_rates.MXN;
  const converted = total.value / conversion_rate;
  form.reference_usd = Math.round(converted);
}

const calcChargeData = (amount) => {
  if(form.method === 'USD'){
    form.receive = amount;
    form.missing = form.reference_usd - amount;
    form.missing *= exchangeRateMxn.value;
    form.missing = Math.round(form.missing);
  }else{
    form.missing = total.value - amount;
  }

  if(form.missing < 0){
    form.return = Math.abs(form.missing);
    form.missing = 0;
  }
}

const handleConfirm = () => {
  console.log('Charge confirm');
}

</script>
