import {defineStore, storeToRefs} from 'pinia';
import { api } from 'boot/axios';

import PaginationService from './../services/PaginationService.js';
import RoleService from "src/services/users/RoleService";
import FormService from "src/services/FormService";

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    user: {},
    roles: RoleService.getRoles(),
    loading: false,
    error: null,
    validationsErrors: null,
    pagination: {
      sortBy: null,
      descending: false,
      page: null,
      rowsPerPage: null,
      rowsNumber: null,
      next: null,
      prev: null,
    },
  }),
  actions: {
    async fetchUsers(params = {}) {
      this.users = [];
      this.loading = true;
      await api
        .get('/api/users/list', {params})
        .then((response) => {
          this.users = response.data.payload.items;

          if (response.data.payload.metadata) {
            this.pagination = PaginationService.getPaginationData(
              response.data.payload.metadata
            );
          }
        })
        .catch((error) => (this.error = error))
        .finally(() => {
          this.loading = false;
        });
    },

    async fetchUser(id) {
      this.user = {};
      this.loading = true;
      await api
        .get(`/api/users/${id}`)
        .then((response) => {
          this.user = response.data.payload;
        })
        .catch((error) => (this.error = error))
        .finally(() => {
          this.loading = false;
        });
    },
    async storeUser(data) {
      this.user = null;
      this.loading = true;
      this.validationsErrors = null;
      this.error = null;

      data = FormService.removeNullProperties(data);

      await api
        .post(`/api/users`, data)
        .then((response) => {
          this.user = response.data.payload;
        })
        .catch((error) => {
          this.error = error;

          if(error.response.status === 400){
            this.validationsErrors = error.response.data.errors;
          }

          if (error.response.status === 422) {
            this.validationsErrors = error.response.data.data;
          }

          console.log(this.error)
        })
        .finally(() => {
          this.loading = false;
        });
    },
    async editUser(data) {
      this.loading = true;
      this.error = null;
      this.validationsErrors = null;

      data = FormService.removeNullProperties(data);
      const id = data.id;

      await api
        .put(`/api/users/${id}`, data)
        .then((response) => {
          this.user = response.data.payload;
        })
        .catch((error) => {
          this.error = error;
          if(error.response.status === 400){
            this.validationsErrors = error.response.data.errors;
          }

          if (error.response.status === 422) {
            this.validationsErrors = error.response.data.data;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    async deleteUser(id) {
      this.loading = true;
      this.error = null;
      this.validationsErrors = null;

      await api
        .delete(`/api/users/${id}`)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          this.error = error;
          if (error.response.status === 422) {
            this.validationsErrors = error.response.data.data;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
});
