import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchHolidayRequest } from './holiday.type'
import type { Holiday } from '#/types/models/holiday'

export default (instance: AxiosInstance) => ({
  getHolidaysList(payload: SearchHolidayRequest): AxiosPromise<{ data: Holiday[] }> {
    return instance.post('/holidays:search', payload)
  },
  getHoliday(id: string, params: SearchHolidayRequest): AxiosPromise<{ data: Holiday }> {
    return instance.get(`/holidays/${id}`, { params })
  },
})
