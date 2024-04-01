import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SeatchCertificateRequest } from './certificate.type'
import type { Certificate } from '#/types/models/certificate'

export default (instance: AxiosInstance) => ({
  postCertificate(payload: SeatchCertificateRequest): AxiosPromise<{ data: Certificate[] }> {
    return instance.post('/certificate_types:search', payload)
  },
})
