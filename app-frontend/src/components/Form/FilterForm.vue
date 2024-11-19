<template>
  <div class="row full-width">
    <div class="col-12 col-sm-10">
      <div class="row q-col-gutter-md">
        <slot name="fields" />
      </div>
    </div>
    <div class="col-12 col-sm-2 text-right">
      <q-btn
        class="q-px-sm q-mr-sm"
        color="red"
        text-color="white"
        @click="onClear"
      >
        <q-icon>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M566.6 54.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192-34.7-34.7c-4.2-4.2-10-6.6-16-6.6c-12.5 0-22.6 10.1-22.6 22.6l0 29.1L364.3 320l29.1 0c12.5 0 22.6-10.1 22.6-22.6c0-6-2.4-11.8-6.6-16l-34.7-34.7 192-192zM341.1 353.4L222.6 234.9c-42.7-3.7-85.2 11.7-115.8 42.3l-8 8C76.5 307.5 64 337.7 64 369.2c0 6.8 7.1 11.2 13.2 8.2l51.1-25.5c5-2.5 9.5 4.1 5.4 7.9L7.3 473.4C2.7 477.6 0 483.6 0 489.9C0 502.1 9.9 512 22.1 512l173.3 0c38.8 0 75.9-15.4 103.4-42.8c30.6-30.6 45.9-73.1 42.3-115.8z"/></svg>
        </q-icon>
        <q-tooltip max-width="14rem" anchor="top middle" self="bottom middle">
          Limpiar filtros
        </q-tooltip>
      </q-btn>
      <q-btn
        class="q-px-sm"
        color="accent"
        text-color="dark"
        icon="search"
        @click="onFilter"
      >
        <q-tooltip max-width="14rem" anchor="top middle" self="bottom middle">
          Buscar
        </q-tooltip>
      </q-btn>
    </div>
  </div>
</template>

<script setup>

import {ref} from "vue";

const emit = defineEmits(['filter', 'clear']);

const onFilter = () => {
  emit('filter');
};

const onClear = () => {
  emit('clear');
}
</script>
