<template>
  <q-page class="bg-darkness q-pa-md">
    <div class="row q-col-gutter-lg">
      <div class="col-12 col-sm-5">
        <q-card class="shadow-10 gradient-border">
          <q-tabs
            v-model="tabOrder"
            class="bg-mor text-white"
            align="left"
            narrow-indicator
            active-color="accent"
            indicator-color="accent"
          >
            <q-tab class="fw-bold" name="orders" label="Comandas" />
            <q-tab class="fw-bold" name="last" label="Última cuenta" />
          </q-tabs>

          <q-separator />

          <q-tab-panels v-model="tabOrder" animated>

            <q-tab-panel name="orders" class="bg-dark">
              <OrdersList
                :items="cart"
                :total="total"
                @confirm="handlePaymentDialog"
                @delete="handleDelete"
                @reset="handleReset"
              />
            </q-tab-panel>

            <q-tab-panel name="last" class="bg-dark">
              <div class="text-h6">Última cuenta</div>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>
      <div class="col-12 col-sm-7">
        <q-card v-if="cashierPaymentDialogShow" class="shadow-10 gradient-border">
          <q-tabs
            v-model="tabTicker"
            class="bg-mor text-white"
            align="left"
            narrow-indicator
            active-color="accent"
            indicator-color="accent"
          >
            <q-tab class="fw-bold" name="select" label="Seleccionar Producto" />
            <q-tab class="fw-bold" name="courtesy" label="Cortesías" />
          </q-tabs>

          <q-separator />

          <q-tab-panels v-model="tabTicker" animated>

            <q-tab-panel name="select" class="bg-dark">
              <ProductSelect
                @add-product="handleAddProduct"
              />
            </q-tab-panel>

            <q-tab-panel name="courtesy" class="bg-dark">
              <ProductSelect
                courtesy
                @add-product="handleAddProduct"
              />
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
        <div v-else class="row q-col-gutter-md text-white">
          <div class="col-4 flex items-center justify-center">
            <q-btn
              class="fw-bold"
              size="lg"
              icon="arrow_back"
              color="accent"
              text-color="dark"
              label="Volver"
              @click="handleBackPaymentComponent"
            />
          </div>
          <div class="col-8">
            <q-card class="shadow-10 gradient-border">
              <q-tabs
                v-model="tabPayment"
                class="bg-mor text-white"
                align="left"
                narrow-indicator
                active-color="accent"
                indicator-color="accent"
              >
                <q-tab v-show="showTabPayment" class="fw-bold" name="method" label="Método de pago" />
                <q-tab v-show="!showTabPayment" class="fw-bold" name="payment" label="Pago" />
              </q-tabs>

              <q-tab-panels v-model="tabPayment" animated>
                <q-tab-panel name="method" class="bg-dark">
                  <q-btn
                    v-for="(methodElem, index) in paymentMethods"
                    :key="index"
                    class="fw-bold full-width q-mb-md"
                    size="lg"
                    icon-left="chevron_right"
                    color="accent"
                    text-color="dark"
                    :label="methodElem"
                    @click="handleSelectPaymentMethod(methodElem)"
                  />
                </q-tab-panel>
                <q-tab-panel name="payment" class="bg-dark">
                  <CashierPaymentForm
                    :cart="cart"
                    :payment-method="paymentMethod"
                    @success="$emit('success')"
                    @cancel="$emit('cancel')"
                  />
                </q-tab-panel>
              </q-tab-panels>

            </q-card>
          </div>
        </div>
      </div>
    </div>

<!--    <CashierPaymentDialog-->
<!--      v-model="cashierPaymentDialogShow"-->
<!--      :cart="cart"-->
<!--      :payment-method="paymentMethod"-->
<!--      @success="handleCashierDialogSuccess"-->
<!--      @cancel="handleCashierDialogCancel"-->
<!--    />-->
  </q-page>
</template>

<script setup>

import OrdersList from "src/modules/CashierRegister/components/OrdersList.vue";

import {computed, ref} from "vue";
import ProductSelect from "src/modules/CashierRegister/components/ProductSelect.vue";
import CartItem from "src/modules/CashierRegister/models/CartItem";
import {storeToRefs} from "pinia";
import {useProductStore} from "src/modules/CashierRegister/stores/product";
import CashierService from "src/modules/CashierRegister/services/CashierService";
import CashierPaymentForm from "src/modules/CashierRegister/components/CashierPaymentForm.vue";

defineOptions({
  name: 'IndexPage'
});

const { products, error } = storeToRefs(useProductStore());

const tabOrder = ref('orders');
const tabTicker = ref('select');
const tabPayment = ref('method');
const showTabPayment = ref(true);

const cashierPaymentDialogShow = ref(true);
const cart = ref([]);
const paymentMethod = ref('');

const total = computed(() => CashierService.getCashierCartTotal(cart.value));
const paymentMethods = computed(() => CashierService.getPaymentMethods());

const handleAddProduct = (data) => {
  const product = products.value.find(t => t.id === data.productId);
  if (!product) return;

  const courtesy = data.courtesy;
  product.price = courtesy ? 0 : product.price;

  const existingItem = cart.value.find(item => item.id === data.productId);
  if (existingItem) {
    existingItem.increment();
  } else {
    const newItem = new CartItem(product.id, product.name, product.price);
    cart.value.push(newItem);
  }
}

const handleReset = () => {
  cart.value = [];
  resetPaymentComponent();
}

const handleDelete = (id) => {
    cart.value = cart.value.filter(item => item.id !== id);
}

const handleCashierDialogSuccess = () => {
  console.log('success');
}

const handlePaymentDialog = (method) => {
  paymentMethod.value = method;
  cashierPaymentDialogShow.value = false;
}

const handleSelectPaymentMethod = (method) => {
  tabPayment.value = 'payment';
  showTabPayment.value = false;
  paymentMethod.value = method;
}

const handleCashierDialogCancel = () => {
  cashierPaymentDialogShow.value = false;
  paymentMethod.value = '';
}

const resetPaymentComponent = () => {
  cashierPaymentDialogShow.value = true;
  tabPayment.value = 'method';
}

const handleBackPaymentComponent = () => {
  if(tabPayment.value === 'method'){
    cashierPaymentDialogShow.value = true;
  }else if(tabPayment.value === 'payment'){
    tabPayment.value = 'method';
    showTabPayment.value = true;
  }
}

</script>
