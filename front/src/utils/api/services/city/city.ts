import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchCityRequest } from './city.type'
import type { City } from '#/types/models/city'

export default (instance: AxiosInstance) => ({
  getCities(payload: SearchCityRequest): AxiosPromise<{ data: City[] }> {
    return instance.post('/cities:search', payload)
  },
})
