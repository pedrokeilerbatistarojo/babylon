<template>
  <q-layout view="lHh Lpr lFf">
    <q-header
      elevated
      class="bg-mor border-babylon-bottom"
    >
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          <img
            v-if="!leftDrawerOpen && !$q.screen.lt.sm"
            alt="Babylon logo"
            src="~assets/logo.png"
            style="width: 180px; height: 40px"
          >
        </q-toolbar-title>

        <div>
          <q-btn
            class="fw-bold font-size-12"
            color="accent"
            icon-right="store"
            flat
            label="Cancún"
          />
          <q-btn
            class="fw-bold font-size-12"
            color="accent"
            icon-right="person"
            flat
            label="Cajero 1"
          />
          <q-btn
            class="fw-bold font-size-12"
            color="red"
            icon-right="logout"
            flat
          />
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      class="bg-dark q-drawer-bordered text-white"
    >
      <q-list>
        <q-item-label
          header
        >
          <img
            alt="Babylon logo"
            src="~assets/logo.png"
            style="width: 180px; height: 40px"
          >
        </q-item-label>
        <div class="border-babylon-top"></div>
        <EssentialLink
          v-for="link in linksList"
          :key="link.title"
          v-bind="link"
        />

        <q-item
          class="q-pa-md"
          clickable
        >
          <q-item-section
            avatar
          >
            <q-icon class="fw-bold font-size-12" color="red" size="sm" name="logout" />
          </q-item-section>

          <q-item-section>
            <q-item-label class="fw-bold text-red">Cerrar sesión</q-item-label>
            <q-item-label caption style="color: #918e8e"></q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import EssentialLink from 'components/EssentialLink.vue'
import {useQuasar} from "quasar";

const $q = useQuasar();

defineOptions({
  name: 'MainLayout'
})

const linksList = [
  {
    title: 'Caja',
    caption: 'Acceso a caja',
    icon: 'point_of_sale',
    link: { name: 'cashier-register' }
  },
  {
    title: 'Arqueo',
    caption: 'Arqueo de caja',
    icon: 'currency_exchange',
    link: { name: 'cash-management' }
  },
  {
    title: 'Transferir',
    caption: 'Transferir caja',
    icon: 'real_estate_agent',
    link: { name: 'transfers' }
  },
]

const leftDrawerOpen = ref(false)

function toggleLeftDrawer () {
  leftDrawerOpen.value = !leftDrawerOpen.value
}
</script>
