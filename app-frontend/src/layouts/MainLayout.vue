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
            class="logo-header"
            v-if="!leftDrawerOpen && !$q.screen.lt.sm"
            alt="Babylon logo"
            src="~assets/logo.png"
            @click="toHome"
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
            :label="userName"
          />
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      class="bg-dark q-drawer-bordered text-white shadow-20"
    >
      <q-list>
        <q-item-label
          header
        >
          <q-img
            class="logo-header"
            alt="Babylon logo"
            src="~assets/logo.png"
            @click="toHome"
          />
        </q-item-label>
        <EssentialLink
          v-for="link in linksList"
          :key="link.title"
          v-bind="link"
        />

        <q-item
          class="q-pa-md"
          clickable
          @click="handleLogout"
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
import {computed, onMounted, ref} from 'vue'
import EssentialLink from 'components/EssentialLink.vue'
import {useQuasar} from "quasar";
import {useAuthStore} from "src/modules/Auth/stores/auth";
import {storeToRefs} from "pinia";
import { useRouter } from 'vue-router';
import AuthService from "src/modules/Auth/services/AuthService";
const router = useRouter();
const $q = useQuasar();

defineOptions({
  name: 'MainLayout'
});

const { error } = storeToRefs(useAuthStore());
const { logout } = useAuthStore();

const userName = computed(() => AuthService.getUserName())

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

const leftDrawerOpen = ref(false);

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value
}

const toHome = () => {
  router.push({ path: '/' });
}

const handleLogout = () => {
  logout();
  router.push({ path: '/login' });
}

</script>

<style scoped>
.logo-header{
  width: 180px;
  height: 40px;
  cursor: pointer;
}

.logo-header :hover{
  width: 180px;
  height: 45px!important;
  cursor: pointer;
  box-shadow: 0 6px 6px -3px #0003, 0 10px 14px 1px #00000024, 0 4px 18px 3px #0000001f!important;
}

</style>
