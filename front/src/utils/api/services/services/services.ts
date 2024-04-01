import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchServicesRequest } from './services.type'
import type { Services } from '#/types/models/services'

export default (instance: AxiosInstance) => ({
  getServices(payload: SearchServicesRequest): AxiosPromise<{ data: Services[] }> {
    return instance.post('/services:search', payload)
  },
})
