import { route } from 'quasar/wrappers'
import {
  createRouter,
  createMemoryHistory,
  createWebHistory,
  createWebHashHistory
} from 'vue-router'
import routes from './routes'
import { useAuthStore } from 'src/modules/Auth/stores/auth';
import SettingStorage from "src/modules/Auth/services/crypt/SettingStorage";

export default route(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : (process.env.VUE_ROUTER_MODE === 'history' ? createWebHistory : createWebHashHistory)

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE)
  })

  Router.beforeEach((to, from) => {
    const authStore = useAuthStore();

    if (!authStore.token) {
      const storedToken = SettingStorage.get("token", null);

      if (storedToken) {
        authStore.token = storedToken.token;
      }
    }

    if (to.meta.requiresAuth && !authStore.token) {
      return { name: 'login', query: { redirect: to.fullPath } };
    }
  });

  return Router
})
