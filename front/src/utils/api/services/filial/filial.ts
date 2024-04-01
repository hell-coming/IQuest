import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchFilialRequest } from './filial.type'
import type { Filial } from '#/types/models/filial'

export default (instance: AxiosInstance) => ({
  getFilialList(payload: SearchFilialRequest): AxiosPromise<{ data: Filial[] }> {
    return instance.post('/filials:search', payload)
  },
})
