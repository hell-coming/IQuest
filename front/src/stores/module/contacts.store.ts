import type { Contact } from '#/types/models/contact'

//* --- State ----------------------------------------------- *//
interface ContactState {
  social: Contact[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useContactStore = defineStore('contact', {
  state: (): ContactState => ({
    social: [],
    error: {},
  }),
  getters: {
    getPhone: (state) => {
      const phone = state.social.find(item => item.type.name === 'Номер телефона')
      return phone?.value || null
    },

    getEmail: (state) => {
      const email = state.social.find(item => item.type.name === 'Почта')
      return email?.value || null
    },

    getSocial: (state) => {
      const social = state.social.filter(item => item.type.is_social === true)
      return social || null
    },

  },
  actions: {
    async fetchContact() {
      const stores = setupStore(['city'])

      try {
        const response = await api.contact.getContact({
          include: ['contactType'],
          filter: {
            city_id: stores.city.selectedCity.id,
          },
        })
        this.social = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
