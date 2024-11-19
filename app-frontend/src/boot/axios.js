import { boot } from 'quasar/wrappers'
import axios from 'axios'
import {useAuthStore} from "src/modules/Auth/stores/auth";
import {storeToRefs} from "pinia";
import SettingStorage from "src/modules/Auth/services/crypt/SettingStorage";

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)

const env = import.meta.env;
const api = axios.create({ baseURL: env.VITE_API_BASE_URL })

export default boot(({ app, router }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api
  const { token } = storeToRefs(useAuthStore());

  api.interceptors.request.use(
    (config) => {
      //let localToken = JSON.parse(localStorage.getItem("token"));
      let localToken = SettingStorage.get("token", null);
      if (localToken) {
        config.headers["Authorization"] = `Bearer ${localToken.token}`;
      }
      return config;
    },
    (error) => {
      return Promise.reject(error);
    }
  );

  api.interceptors.response.use(
    (response) => {
      return response;
    },
    (error) => {
      if (error.response && error.response.status === 401) {
        token.value = null;
        //localStorage.removeItem("token");
        SettingStorage.remove("token");
        const loginPath = "/login?redirect=" + router.currentRoute.value.path;

        router.push(loginPath);
      }

      return Promise.reject(error);
    }
  );

  app.config.globalProperties.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export { api }
