import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchContactRequest } from './contact.type'
import type { Contact } from '#/types/models/contact'

export default (instance: AxiosInstance) => ({
  getContact(payload: SearchContactRequest): AxiosPromise<{ data: Contact[] }> {
    return instance.post('/contacts:search', payload)
  },
})
