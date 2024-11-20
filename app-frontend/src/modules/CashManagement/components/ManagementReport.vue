<template>
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
      <FilterForm @filter="fetchReports(params)" >
        <template #fields >
          <div class="col">
            <SelectInput
              v-model="filters.local"
              :options="localOptions"
              @keyup.enter="fetchReports(params)"
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
              @keyup.enter="fetchReports(params)"
            />
          </div>
          <div class="col">
            <NumberInput
              v-model="filters.cashier_close"
              @keyup.enter="fetchReports(params)"
              label="Cierre de caja"
            />
          </div>
        </template>
      </FilterForm>
    </template>
  </q-table>
</template>

<script setup>
import {computed, reactive} from "vue";
import ManagementService from "src/modules/CashManagement/services/ManagementService";
import FilterForm from "components/Form/FilterForm.vue";
import DateInput from "components/Form/DateInput.vue";
import NumberInput from "components/Form/NumberInput.vue";
import SelectInput from "components/Form/SelectInput.vue";

const rows = computed(() => ManagementService.getFakeData());
const columns = computed(() => ManagementService.getReportColumns());

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

</script>

<style scoped>

</style>
