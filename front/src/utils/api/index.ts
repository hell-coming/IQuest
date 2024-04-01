import axios from 'axios'

import QuestApi from './services/quest/quest'
import SharedApi from './services/shared/shared'
import StocksApi from './services/stocks/stocks'
import ServicesApi from './services/services/services'
import HolidaysApi from './services/holiday/holiday'
import BookingApi from './services/booking/booking'
import FilialApi from './services/filial/filial'
import CertificateApi from './services/certificate/certificate'
import CityApi from './services/city/city'
import ContactApi from './services/contact/contact'

import { RequestErrorInterceptor } from './interceptors/request-error'

const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'https://iquest-dev.tomsk-it.ru/api',
})

RequestErrorInterceptor(instance)

export const api = {
  city: CityApi(instance),
  shared: SharedApi(instance),
  quest: QuestApi(instance),
  stocks: StocksApi(instance),
  services: ServicesApi(instance),
  holidays: HolidaysApi(instance),
  booking: BookingApi(instance),
  filial: FilialApi(instance),
  certificate: CertificateApi(instance),
  contact: ContactApi(instance),
}
