<template>
  <div>
    <div class="row q-col-gutter-sm">
      <div
        v-for="ticket in tickets"
        class="col-6 col-sm-6"
        :key="ticket.id"
        @click="addTicket(ticket.id)"
      >
        <div class="bg-mor div-ticket">
          <div class="row q-pa-md">
            <div class="col-6 col-sm-5 flex items-center">
              <img
                alt="Presentation Image"
                src="~assets/babylon-logo.webp"
                style="width: 100%; height: auto"
              >
            </div>
            <div class="col text-center">
              <div class="font-size-16 fw-bold block text-white">{{ ticket.label }}</div>
              <div class="block text-white font-size-16">$ {{ ticket.price }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { ref, computed } from 'vue';
import ticketsData from 'src/modules/CashierRegister/services/ticketFacker.json';

const emit = defineEmits([
  'add-ticket',
]);


const tickets = ref(ticketsData);

const addTicket = (ticket) => {
  emit('add-ticket', ticket);
};


</script>

<style scoped>
  .div-ticket{
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .div-ticket :hover{
    border-radius: 4px;
    background-color: #120533;
    color: black;
    animation: wave 0.6s ease-in-out infinite;
  }

  @keyframes wave {
    0%, 100% {
      transform: scale(1); /* tamaño normal */
    }
    50% {
      transform: scale(1.05); /* tamaño aumentado */
    }
  }
</style>
