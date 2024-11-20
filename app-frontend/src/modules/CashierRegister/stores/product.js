import {defineStore} from 'pinia';
import { api } from 'boot/axios';
import PaginationService from "src/services/PaginationService";
import FormService from "src/services/FormService";

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
    product: {},
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
    async fetchProducts(params = {}) {
      this.products = [];
      this.loading = true;
      await api
        .get('/api/products', {params})
        .then((response) => {
          this.products = response.data.payload.items;

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

    async fetchProduct(id) {
      this.product = {};
      this.loading = true;
      await api
        .get(`/api/products/${id}`)
        .then((response) => {
          this.product = response.data.payload;
        })
        .catch((error) => (this.error = error))
        .finally(() => {
          this.loading = false;
        });
    },
    async storeProduct(data) {
      this.product = null;
      this.loading = true;
      this.validationsErrors = null;
      this.error = null;

      data = FormService.removeNullProperties(data);

      await api
        .post(`/api/products`, data)
        .then((response) => {
          this.product = response.data.payload;
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
    async editProduct(data) {
      this.loading = true;
      this.error = null;
      this.validationsErrors = null;

      data = FormService.removeNullProperties(data);
      const id = data.id;

      await api
        .put(`/api/products/${id}`, data)
        .then((response) => {
          this.product = response.data.payload;
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
    async deleteProduct(id) {
      this.loading = true;
      this.error = null;
      this.validationsErrors = null;

      await api
        .delete(`/api/products/${id}`)
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
