import type { Certificate } from '#/types/models/certificate'

//* --- State ----------------------------------------------- *//
interface CertificateListState {
  сertificateList: Certificate[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useCertificateListStore = defineStore('сertificateList', {
  state: (): CertificateListState => ({
    сertificateList: [],
    error: {},
  }),
  getters: {
    getFirstCertificate: state => state.сertificateList[0],
  },
  actions: {
    async fetchCertificates() {
      try {
        const response = await api.certificate.postCertificate({})
        this.сertificateList = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
