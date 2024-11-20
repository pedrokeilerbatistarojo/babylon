<template>
  <q-page class="bg-dark q-pa-md">
    <div class="row q-col-gutter-md">
      <div class="col-12">
        <q-card class="shadow-10">
          <q-tabs
            v-model="tab"
            class="bg-mor text-white"
            align="start"
            narrow-indicator
            active-color="accent"
            indicator-color="primary"
          >
            <q-tab class="fw-bold" name="management" label="Reporte de arqueo" />
            <q-tab class="fw-bold" name="sales" label="Reporte de ventas" />
          </q-tabs>

          <q-separator />

          <q-tab-panels v-model="tab" animated>

            <q-tab-panel name="management">
              <ManagementReport />
            </q-tab-panel>

            <q-tab-panel name="sales">
              <ManagementReport />
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>

    </div>
  </q-page>
</template>

<script setup>

import {ref} from "vue";
import ManagementReport from "src/modules/CashManagement/components/ManagementReport.vue";

defineOptions({
  name: 'IndexPage'
});

const tab = ref('management');
</script>
