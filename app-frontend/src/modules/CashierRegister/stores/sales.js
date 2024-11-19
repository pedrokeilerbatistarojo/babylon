import {defineStore, storeToRefs} from 'pinia';
import { api } from 'boot/axios';

import PaginationService from 'src/services/PaginationService';

export const useSalesStore = defineStore('sales', {
  state: () => ({
    orders: [],
    order: {},
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
    async fetchOrders(params = {}) {
      this.orders = [];
      this.loading = true;
      setTimeout(() => {
        // this.orders = [
        //   { id: 1, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        //   { id: 2, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        //   { id: 3, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        //   { id: 4, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        //   { id: 5, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        //   { id: 6, quantity: 1, name: "Adulto",description: "+ Niño", price: "100.00"},
        // ];

        this.loading = false;

      } , 1000);
    },

    async fetchOrder(id) {
      this.order = {};
      this.loading = true;

      setTimeout(() => {
        this.order = this.orders.find(item => item.id === id);
        this.loading = false;
      }, 1000);
    },
    // async storeUser(data) {
    //   this.user = null;
    //   this.loading = true;
    //   this.validationsErrors = null;
    //   this.error = null;
    //
    //   data = FormService.removeNullProperties(data);
    //
    //   await api
    //     .post(`/api/users`, data)
    //     .then((response) => {
    //       this.user = response.data.payload;
    //     })
    //     .catch((error) => {
    //       this.error = error;
    //
    //       if(error.response.status === 400){
    //         this.validationsErrors = error.response.data.errors;
    //       }
    //
    //       if (error.response.status === 422) {
    //         this.validationsErrors = error.response.data.data;
    //       }
    //
    //       console.log(this.error)
    //     })
    //     .finally(() => {
    //       this.loading = false;
    //     });
    // },
    // async editUser(data) {
    //   this.loading = true;
    //   this.error = null;
    //   this.validationsErrors = null;
    //
    //   data = FormService.removeNullProperties(data);
    //   const id = data.id;
    //
    //   await api
    //     .put(`/api/users/${id}`, data)
    //     .then((response) => {
    //       this.user = response.data.payload;
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
    // async deleteUser(id) {
    //   this.loading = true;
    //   this.error = null;
    //   this.validationsErrors = null;
    //
    //   await api
    //     .delete(`/api/users/${id}`)
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
