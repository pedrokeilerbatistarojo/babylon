<template>
  <p class="font-size-16 text-center fw-bold text-dark">Resumen de la jornada</p>
  <RowDetailDoubleResume
    bolder-title
    title="Ventas en efectivo"
    currency="MXN"
    amount="$ 0"
    currency-secondary="USD"
    amount-secondary="$ 0"
    converted="(MXN 0)"
  />
  <q-separator></q-separator>

  <RowDetailResume
    bolder-title
    title="Ventas en tarjeta"
    currency="MXN"
    amount="$ 0"
  />
  <q-separator color="dark"></q-separator>

  <RowDetailResume
    title="Ventas Total Referencial"
    currency="MXN"
    amount="$ 0"
  />
  <q-separator></q-separator>

  <RowDetailResume
    bolder-title
    title="Total Recibido en USD"
    currency="USD"
    amount="$ 0"
    converted="(MXN 0)"
  />
  <q-separator></q-separator>

  <RowDetailResume
    bolder-title
    title="Cambio de USD en MXN"
    currency="MXN"
    amount="$ 0"
    converted="(USD 0)"
  />
  <q-separator color="dark"></q-separator>

  <RowDetailResume
    title="Fondo de Caja Inicial"
    currency="MXN"
    amount="$ 685.00"
  />
  <q-separator></q-separator>

  <RowDetailDoubleResume
    title="Monto Total en Caja"
    currency="MXN"
    amount="$ 695.00"
    currency-secondary="USD"
    amount-secondary="$ 0"
  />
  <q-separator color="dark"></q-separator>
  <div class="text-center fw-bold text-dark text-uppercase">Totales a transferir</div>
  <q-separator></q-separator>

  <RowDetailDoubleResume
    bolder-title
    title="Efectivo"
    currency="MXN"
    amount="$ 0"
    currency-secondary="USD"
    amount-secondary="$ 0"
    converted="(MXN 0)"
  />
  <q-separator></q-separator>

  <RowDetailResume
    bolder-title
    title="Tarjeta"
    currency="MXN"
    amount="$ 0"
  />
  <q-separator color="dark"></q-separator>

  <RowDetailResume
    bolder-title
    title="Suma Total a Transf. Referencial"
    currency="MXN"
    amount="$ 0"
  />
  <q-separator></q-separator>

  <RowDetailResume
    bolder-title
    title="Fondo de Caja después de Corte"
    currency="MXN"
    amount="$ 695.00"
  />
  <q-separator color="dark"></q-separator>
  <div class="text-center fw-bold text-dark text-uppercase">Diferencias de fondo de caja</div>
  <q-separator></q-separator>
  <div class="row items-center">
    <div class="col text-center">MXN</div>
    <div class="col text-center">USD</div>
    <div class="col text-center">Tarjeta</div>
  </div>
  <q-separator></q-separator>
  <div class="row items-center">
    <div class="col text-center">$ 0</div>
    <div class="col text-center">$ 0</div>
    <div class="col text-center">$ 0</div>
  </div>
</template>

<script setup>
import RowDetailDoubleResume from "src/modules/Transfers/components/RowDetailDoubleResume.vue";
import RowDetailResume from "src/modules/Transfers/components/RowDetailResume.vue";

const props = defineProps({
  transfer: Object
});
</script>

<style scoped>

</style>
