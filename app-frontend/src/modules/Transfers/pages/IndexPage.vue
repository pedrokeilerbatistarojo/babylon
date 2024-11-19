<template>
  <q-page class="bg-dark q-pa-md">
    <div class="row q-col-gutter-md">
      <div class="col-12">
        <q-card class="shadow-10">
          <TransferList />
        </q-card>
      </div>
    </div>

  </q-page>
</template>

<script setup>

import TransferList from "src/modules/Transfers/components/TransferList.vue";

defineOptions({
  name: 'IndexPage'
});
</script>
