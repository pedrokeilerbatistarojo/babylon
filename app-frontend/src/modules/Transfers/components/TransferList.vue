<template>
  <div>
    <div class="q-px-md q-py-sm bg-mor flex justify-between items-center">
      <div class="text-uppercase fw-bold text-accent">Transferencias</div>
      <q-btn
        class="fw-bold"
        text-color="dark"
        color="accent"
        @click="handleTransferCashier"
        label="Transferir caja"
      />
    </div>
    <q-table
      flat bordered
      :rows="rows"
      :columns="columns"
      row-key="name"
      binary-state-sort
      loading-label="Cargando..."
      no-data-label="No hay datos que mostrar"
      no-results-label="No hay datos que mostrar"
      rows-per-page-label="Elementos por página"
      :rows-per-page-options="[5, 7, 10, 20, 50]"
    >
      <template #top>
        <FilterForm @filter="fetchTransfers(params)" >
          <template #fields >
            <div class="col">
              <SelectInput
                v-model="filters.local"
                :options="localOptions"
                @keyup.enter="fetchTransfers(params)"
                label="Todos los locales"
              />
            </div>
            <div class="col">
              <DateInput
                v-model="filters.start_date"
                label="Desde"
                @keyup.enter="fetchReports(params)"
              />
            </div>
            <div class="col">
              <DateInput
                v-model="filters.end_date"
                label="Hasta"
                @keyup.enter="fetchTransfers(params)"
              />
            </div>
            <div class="col">
              <NumberInput
                v-model="filters.cashier_close"
                @keyup.enter="fetchTransfers(params)"
                label="Cierre de caja"
              />
            </div>
          </template>
        </FilterForm>
      </template>
    </q-table>
  </div>

  <TransferCashierDialog
    v-model="transferDialogShow"
    @success="handleSuccess"
    @cancel="handleCancel"
  />
</template>

<script setup>
import {computed, reactive, ref} from "vue";
import FilterForm from "components/Form/FilterForm.vue";
import DateInput from "components/Form/DateInput.vue";
import NumberInput from "components/Form/NumberInput.vue";
import SelectInput from "components/Form/SelectInput.vue";
import TransferService from "src/modules/Transfers/services/TransferService";
import TransferCashierDialog from "src/modules/Transfers/components/TransferCashierDialog.vue";

const rows = computed(() => TransferService.getFakeData());
const columns = computed(() => TransferService.getReportColumns());

const transferDialogShow = ref(false);

const filters = reactive({
  start_date: null,
  end_date: null,
  local: null,
  cashier_close: null,
});

const params = reactive({
  filters: [],
  itemsPerPage: 8,
  currentPage: 1
});

const handleTransferCashier = () => {
  transferDialogShow.value = true;
}

const handleSuccess = () => {
  console.log('success');
}

const handleCancel = () => {
  transferDialogShow.value = false;
}

</script>

<style scoped>

</style>
