import { defineStore } from 'pinia'
import type { Stocks } from '#/types/models/stocks'

//* --- State ----------------------------------------------- *//
interface StocksState {
  stocks: Stocks[] | null
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useStocksStore = defineStore('stocks', {
  state: (): StocksState => ({
    stocks: null,
    error: {},
  }),
  actions: {
    async fetchStocks() {
      const stores = setupStore(['city'])
      try {
        const response = await api.stocks.getStocks({
          include: [],
          filter: {
            city_id: stores.city.selectedCity.id,
            is_active: true,
          },
        })
        this.stocks = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
