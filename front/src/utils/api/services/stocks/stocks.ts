import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchStocksRequest } from './stocks.types'
import type { Stocks } from '#/types/models/stocks'

export default (instance: AxiosInstance) => ({
  getStocks(payload: SearchStocksRequest): AxiosPromise<{ data: Stocks[] }> {
    return instance.post('/sales:search', payload)
  },
})
