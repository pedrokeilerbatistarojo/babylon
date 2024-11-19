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
            <q-tab class="fw-bold" name="select" label="Seleccionar Ticket" />
            <q-tab class="fw-bold" name="courtesy" label="Cortesías" />
          </q-tabs>

          <q-separator />

          <q-tab-panels v-model="tabTicker" animated>

            <q-tab-panel name="select">
              <OrdersSelect
                @add-ticket="handleAddTicket"
              />
            </q-tab-panel>

            <q-tab-panel name="courtesy">
              <div class="text-h6">Última cuenta</div>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
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
  </q-page>
</template>

<script setup>

import OrdersList from "src/modules/CashierRegister/components/OrdersList.vue";

import {computed, ref} from "vue";
import OrdersSelect from "src/modules/CashierRegister/components/OrdersSelect.vue";
import ticketsData from "src/modules/CashierRegister/services/ticketFacker.json";
import { Notify, useQuasar} from "quasar";
import CartItem from "src/modules/CashierRegister/models/CartItem";

const $q = useQuasar();

defineOptions({
  name: 'IndexPage'
});


const tabOrder = ref('orders');
const tabTicker = ref('select');

const tickets = ref(ticketsData);
const cart = ref([]);

const total = computed(() => {
  return cart.value.reduce((sum, item) => sum + item.subtotal, 0);
});

const handleAddTicket = (ticketId) => {
  const ticket = tickets.value.find(t => t.id === ticketId);
  if (!ticket) return;

  const existingItem = cart.value.find(item => item.id === ticketId);
  if (existingItem) {
    existingItem.increment();
  } else {
    const newItem = new CartItem(ticket.id, ticket.label, ticket.price);
    cart.value.push(newItem);
  }
}

const handleReset = () => {
  cart.value = [];
}

const handleDelete = (id) => {
    cart.value = cart.value.filter(item => item.id !== id);

}
</script>
