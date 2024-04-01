import { defineStore } from 'pinia'

//* --- State ----------------------------------------------- *//
interface IGlobalState {
  loading: boolean
  isInitialized: boolean
  isOpenModal: boolean
}

//* --- Store ----------------------------------------------- *//
export const useGlobalStore = defineStore('global', {
  state: (): IGlobalState => ({
    loading: true,
    isInitialized: false,
    isOpenModal: false,
  }),

  actions: {
    setLoading(display: boolean) {
      this.loading = display
    },

    async initializeApp() {
      const stores = setupStore(['global', 'filialList', 'holidaysList', 'contact', 'city'])

      await stores.city.fetchCities()

      await Promise.allSettled([
        stores.contact.fetchContact(),
        stores.filialList.fetchFilial(),
        stores.holidaysList.fetchHolidaysList(),
      ])

      this.isInitialized = true
    },
  },
})
