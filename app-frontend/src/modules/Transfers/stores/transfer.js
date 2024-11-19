import {defineStore, storeToRefs} from 'pinia';
import { api } from 'boot/axios';

import PaginationService from 'src/services/PaginationService';
import FormService from "src/services/FormService";

export const useTransferStore = defineStore('transfer', {
  state: () => ({
    transfers: [],
    transfer: {},
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
    async fetchTransfers(params = {}) {
      this.orders = [];
      this.loading = true;

      await api
        .get('/api/transfers', {params})
        .then((response) => {
          this.orders = response.data.payload.items;

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

    async fetchOrder(id) {
      this.transfer = {};
      this.loading = true;

      setTimeout(() => {
        this.transfer = this.orders.find(item => item.id === id);
        this.loading = false;
      }, 1000);
    },
    async storeTransfer(data) {
      this.transfer = null;
      this.loading = true;
      this.validationsErrors = null;
      this.error = null;

      data = FormService.removeNullProperties(data);

      await api
        .post(`/api/transfers`, data)
        .then((response) => {
          this.transfer = response.data.payload;
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
    // async editTransfer(data) {
    //   this.loading = true;
    //   this.error = null;
    //   this.validationsErrors = null;
    //
    //   data = FormService.removeNullProperties(data);
    //   const id = data.id;
    //
    //   await api
    //     .put(`/api/transfers/${id}`, data)
    //     .then((response) => {
    //       this.transfer = response.data.payload;
    //     })
    //     .catch((error) => {
    //       this.error = error;
    //       if(error.response.status === 400){
    //         this.validationsErrors = error.response.data.errors;
    //       }
    //
    //       if (error.response.status === 422) {
    //         this.validationsErrors = error.response.data.data;
    //       }
    //     })
    //     .finally(() => {
    //       this.loading = false;
    //     });
    // },
    // async deleteTransfers(id) {
    //   this.loading = true;
    //   this.error = null;
    //   this.validationsErrors = null;
    //
    //   await api
    //     .delete(`/api/transfers/${id}`)
    //     .then((response) => {
    //       console.log(response);
    //     })
    //     .catch((error) => {
    //       this.error = error;
    //       if (error.response.status === 422) {
    //         this.validationsErrors = error.response.data.data;
    //       }
    //     })
    //     .finally(() => {
    //       this.loading = false;
    //     });
    // },
  },
});
