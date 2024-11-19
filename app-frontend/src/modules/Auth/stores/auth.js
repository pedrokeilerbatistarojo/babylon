import { defineStore } from 'pinia';
import { api } from 'boot/axios';
import SettingStorage from "src/modules/Auth/services/crypt/SettingStorage";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    // token: JSON.parse(localStorage.getItem('token')),
    token: SettingStorage.get("token", null)?.token,
    user: null,
    returnUrl: null,
    error: null,
    validationsErrors: null,
  }),
  actions: {
    async login(username, password) {
      this.error = null;
      const loginData = {
        username: username,
        password: password,
      };

      await api
        .post('/api/auth/login', loginData)
        .then((response) => {
          this.token = response.data.payload;

          SettingStorage.set('token', JSON.stringify(this.token));
          //localStorage.setItem('token', JSON.stringify(this.token));
        })
        .catch((error) => {
          this.error = error;
        });
    },
    async refreshToken() {
      this.error = null;
      await api
        .post('/api/auth/refresh')
        .then((response) => {
          this.token = response.data.payload;
          SettingStorage.set('token', JSON.stringify(this.token));
        })
        .catch((error) => {
          this.error = error;
        });
    },
    async logout() {
      this.token = null;
      this.user = null;
      SettingStorage.remove('token');
      //localStorage.removeItem('token');
      location.reload();
    },

    async fetchProfile() {
      await api
        .post('/api/auth/me?includes=defaultCompany')
        .then((response) => (this.user = response.data.data))
        .catch((error) => {
          this.error = error;
          if (error.response.status === 422) {
            this.validationsErrors = error.response.data.data;
          }
        });
    },
  },
});
