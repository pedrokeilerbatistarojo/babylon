<template>
  <q-page class="bg-dark q-pa-md">
    <div class="row q-col-gutter-md">
      <div class="col-12 col-sm-6">
        <q-card class="shadow-10">
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

            <q-tab-panel name="select">
              <ProductSelect
                @add-product="handleAddProduct"
              />
            </q-tab-panel>

            <q-tab-panel name="courtesy">
              <ProductSelect
                courtesy
                @add-product="handleAddProduct"
              />
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>
      <div class="col-12 col-sm-6">
        <q-card class="shadow-10">
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

            <q-tab-panel name="orders">
              <OrdersList
                :items="cart"
                :total="total"
                @confirm="handlePaymentDialog"
                @delete="handleDelete"
                @reset="handleReset"
              />
            </q-tab-panel>

            <q-tab-panel name="last">
              <div class="text-h6">Última cuenta</div>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>
    </div>

    <CashierPaymentDialog
      v-model="cashierPaymentDialogShow"
      :cart="cart"
      @success="handleCashierDialogSuccess"
      @cancel="handleCashierDialogCancel"
    />
  </q-page>
</template>

<script setup>

import OrdersList from "src/modules/CashierRegister/components/OrdersList.vue";

import {computed, ref} from "vue";
import ProductSelect from "src/modules/CashierRegister/components/ProductSelect.vue";
import CartItem from "src/modules/CashierRegister/models/CartItem";
import {storeToRefs} from "pinia";
import {useProductStore} from "src/modules/CashierRegister/stores/product";
import CashierPaymentDialog from "src/modules/CashierRegister/components/CashierPaymentDialog.vue";
import TransferCashierDialog from "src/modules/Transfers/components/TransferCashierDialog.vue";
import CashierService from "src/modules/CashierRegister/services/CashierService";

defineOptions({
  name: 'IndexPage'
});

const { products, error } = storeToRefs(useProductStore());

const tabOrder = ref('orders');
const tabTicker = ref('select');

const cashierPaymentDialogShow = ref(false);
const cart = ref([]);

const total = computed(() => CashierService.getCashierCartTotal(cart.value));

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
}

const handleDelete = (id) => {
    cart.value = cart.value.filter(item => item.id !== id);
}

const handleCashierDialogSuccess = () => {
  console.log('success');
}

const handlePaymentDialog = () => {
  cashierPaymentDialogShow.value = true;
}

const handleCashierDialogCancel = () => {
  cashierPaymentDialogShow.value = false;
}

</script>
