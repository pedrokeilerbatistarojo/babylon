<template>
  <div>
    <div v-if="!loading" class="row q-col-gutter-sm">
      <div
        v-for="product in productList"
        class="col-6 col-sm-4 q-pa-sm flex flex-center"
        :key="product.id"
        @click="addProduct(product.id)"
      >
        <div class="bg-mor div-product">
          <div class="row q-pa-md">
            <div class="col-6 col-sm-5 flex items-center">
              <img
                alt="Presentation Image"
                src="~assets/babylon-logo.webp"
                style="width: 100%; height: auto"
              >
            </div>
            <div class="col text-center">
              <div class="font-size-16 fw-bold block text-white">{{ product.name }}</div>
              <div class="block text-white font-size-16">$ {{ product.price }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="row q-col-gutter-sm flex-center">
      <div class="q-pa-lg">
        <q-spinner-dots
          color="accent"
          size="6em"
        />
        <q-tooltip :offset="[0, 8]">Cargando, espere por favor</q-tooltip>
      </div>
    </div>
  </div>
</template>

<script setup>

import {computed, onMounted} from 'vue';
import {useProductStore} from "src/modules/CashierRegister/stores/product";
import {storeToRefs} from "pinia";

const { products, loading, error } = storeToRefs(useProductStore());
const { fetchProducts } = useProductStore();

const emit = defineEmits([
  'add-product',
]);

const props = defineProps({
  courtesy: {
    type: Boolean,
    default: false
  }
});

onMounted(() => {
  if(products.value.length === 0){
    fetchProducts();
  }
});

const productList = computed(() => {
  return products.value.map((product) => ({
    ...product,
    price: props.courtesy ? 0 : product.price,
  }));
});

const addProduct = (productId) => {
  emit('add-product', {
    productId: productId,
    courtesy: props.courtesy
  });
};


</script>

<style scoped>
  .div-product{
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .div-product :hover{
    border-radius: 4px;
    background-color: #5701D2;
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
