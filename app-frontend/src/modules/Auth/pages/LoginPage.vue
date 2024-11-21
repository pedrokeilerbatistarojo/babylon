<template>
  <div class="row items-start content-center justify-center login-wrapper bg-dark">
    <div
      style="border-radius: 20px;"
      class="bg-mor gradient-border login-card col-10 col-sm-6 col-md-4 col-lg-3 justify-center content-center q-pa-lg shadow-20"
    >
      <div class="flex justify-center q-mb-lg">
        <q-img
          class="q-mb-lg"
          alt="Presentation Image"
          src="~assets/babylon-logo.webp"
          loading="lazy"
          spinner-color="white"
          style="max-width: 200px"
        />
      </div>

      <q-form @submit.prevent="sendLogin">

        <div class="q-gutter-md">
          <span style="color: #a6a8a9" class="q-mt-lg">Nombre de Usuario:</span>
          <q-input
            outlined
            color="accent"
            bg-color="white"
            class="q-mt-none q-mb-sm"
            v-model="loginData.username"
            type="text"
            :rules="[val => !!val || 'Nombre de usuario es requerido']"
          />

          <span style="color: #a6a8a9" class="q-mt-lg">Contraseña:</span>
          <q-input
            outlined
            color="accent"
            bg-color="white"
            class="q-mt-none q-mb-sm p-input"
            v-model="loginData.password"
            :type="isPwd ? 'password' : 'text'"
            :rules="[val => !!val || 'Contraseña es requerido']"
          >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </div>

        <div class="row justify-end q-mt-sm q-mb-md" v-if="!loading">
          <q-btn
            size="lg"
            color="accent"
            text-color="dark"
            class="text-capitalize full-width fw-bold"
            label="Iniciar Sesión"
            type="submit"
          >
          </q-btn>
        </div>
        <div v-else class="flex flex-center">
          <q-spinner-dots
            color="accent"
            size="6em"
          />
          <q-tooltip :offset="[0, 8]">Cargando, espere por favor</q-tooltip>
        </div>
      </q-form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref} from 'vue';
import { useQuasar } from 'quasar';
import { useRouter, useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import {useAuthStore} from "src/modules/Auth/stores/auth";
import {useExchangeStore} from "src/modules/CashierRegister/stores/exchange";
const $q = useQuasar();
const router = useRouter();
const route = useRoute();
const loginData = reactive({
  username: '',
  password: '',
});
const loading = ref(false);
const isPwd = ref(true);
const { login } = useAuthStore();
const { error } = storeToRefs(useAuthStore());

const { fetchExchangeRate } = useExchangeStore();

const sendLogin = async () => {
  loading.value = true;

  if (!loginData.username || !loginData.password) {
    $q.notify({
      type: 'negative',
      message: 'You must fill out all fields',
    });

    loading.value = false;
  } else {
    await login(loginData.username, loginData.password)
      .then(() => {
        if (error.value) {
          if (error.value.response && error.value.response.status === 401) {
            $q.notify({
              type: 'negative',
              caption: error.value.message,
              message: 'Ha ocurrido un error al intentar iniciar',
            });
          } else {
            console.log(error);
            $q.notify({
              type: 'negative',
              caption: 'Verificar credenciales',
              message: 'Ha ocurrido un error al intentar iniciar.',
            });
          }
        } else {

          let redirectPath = '/';

          fetchExchangeRate();

          router.push({ path: redirectPath, hash: '#login' });
        }
      })
      .finally(() => (loading.value = false));
  }
};

</script>

<style scoped>
.login-wrapper {
  height: 100vh;
}

.login-wrapper::before {
  content: '';
  //background-image: v-bind(backgroundImage);
  background-size: cover;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  opacity: 0.54;
}
</style>
