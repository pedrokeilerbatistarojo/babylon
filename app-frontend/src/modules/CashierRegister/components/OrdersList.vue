<template>
  <div>
    <q-scroll-area style="height: 250px; max-width: 100%;" ref="scrollAreaRef">
      <q-list bordered separator ref="itemList" style="background-color: #5f2ca8 ">
        <q-item class="bg-mor text-white fw-bold">
          <q-item-section>
            <div>CANT.</div>
          </q-item-section>
          <q-item-section>
            <div>ITEM</div>
          </q-item-section>
          <q-item-section class="text-right">
            <div>COSTO</div>
          </q-item-section>
          <q-item-section class="text-right">
            <div>ACCIÓN</div>
          </q-item-section>
        </q-item>

        <q-item
          v-for="(item, index) in items"
          :key="item.id"
          clickable
          v-ripple
          :active="index === activeIndex"
          class="text-white"
          @click="activeIndex = index"
        >
          <q-item-section>
            <q-item-label>{{item.quantity}}</q-item-label>
          </q-item-section>
          <q-item-section>
            <q-item-label class="fw-bold">{{item.name}}</q-item-label>
<!--            <q-item-label caption class="font-size-10">{{item.description}}</q-item-label>-->
          </q-item-section>
          <q-item-section class="text-right">
            <q-item-label >$ {{item.price}}</q-item-label>
          </q-item-section >
          <q-item-section class="text-right">
            <q-item-label >
              <q-btn
                color="red"
                icon-right="delete"
                size="sm"
                @click="deleteItem(item.id)"
              >
                <q-tooltip>Eliminar</q-tooltip>
              </q-btn>
            </q-item-label>
          </q-item-section>
        </q-item>
        <q-item
          v-if="loading"
        >
          <q-item-section >
            <div class="q-pa-md">
              <div class="q-gutter-md row justify-center">
                <q-spinner
                  color="primary"
                  size="3em"
                />
              </div>
            </div>
          </q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
<!--    <div class="row bg-mor q-pa-md">-->
<!--      <div class="col flex justify-between">-->
<!--        <div class="text-white">#Cta: C2.14576</div>-->
<!--        <div class="text-white">#Folio: F2.15683</div>-->
<!--      </div>-->
<!--    </div>-->
    <div class="row bg-dark q-pa-md border-babylon-top">
      <div class="col flex justify-between">
        <div class="text-primary font-size-20 fw-bold">Total a pagar: </div>
        <div class="text-primary font-size-20 fw-bold">$ {{props.total}}</div>
      </div>
    </div>
    <div class="row bg-dark q-px-md q-pt-md border-babylon-top">
      <div class="col flex justify-between">
        <q-btn color="negative" label="Limpiar" @click="resetCart" class="fw-bold" />
        <q-btn :disable="!isValidCharge" color="accent" text-color="dark" label="Cobrar" @click="handleConfirm" class="fw-bold" />
      </div>
    </div>
  </div>
</template>

<script setup>

import {computed, ref} from "vue";

const props = defineProps({
  items: Object,
  total: Number
});

const emit = defineEmits([
  'delete',
  'reset',
  'confirm'
]);

const isValidCharge = computed(() => props.total > 0);
const itemList = ref(null);

const loading = ref(false);
const activeIndex = ref(0);
const scrollAreaRef = ref(null);
const showPaymentMethod = ref(false);

const deleteItem = (index) => {
  emit('delete', index);
  const childElementCount = itemList.value.$el.childElementCount;
  if(childElementCount === 2){
    showPaymentMethod.value = false;
  }

};

const resetCart = () => {
  emit('reset');
  showPaymentMethod.value = false;
};

const handleConfirm = () => {
  emit('confirm');
}

</script>

<style scoped>
</style>
