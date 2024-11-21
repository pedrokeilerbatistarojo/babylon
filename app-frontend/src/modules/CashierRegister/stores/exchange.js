import {defineStore} from 'pinia';
import axios from 'axios'

export const useExchangeStore = defineStore('exchange', {
  state: () => ({
    exchange: null,
    loading: false,
    error: null,
  }),
  actions: {
    async fetchExchangeRate() {
      this.exchange = null;
      this.loading = true;
      await axios.get('https://v6.exchangerate-api.com/v6/f463bb56c7bcab452fc80047/latest/USD')
        .then((response) => {
          this.exchange = response.data;
          console.log(this.exchange);
        })
        .catch((error) => (this.error = error))
        .finally(() => {
          this.loading = false;
        });

    },
  },
});
