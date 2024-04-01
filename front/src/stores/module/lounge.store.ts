import type { Filial } from '#/types/models/filial'

//* --- State ----------------------------------------------- *//
interface FilialListState {
  filialList: Filial[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useFilialListStore = defineStore('filialList', {
  state: (): FilialListState => ({
    filialList: [],
    error: {},
  }),
  getters: {
    getFirstFilial: state => state.filialList?.[0],

    getFirstLounge: state => state.filialList.find(item => item.lounges.length > 0),
    getFirstRoom: state => state.filialList.find(item => item.lounges.length > 0)?.lounges[0],
  },
  actions: {
    async fetchFilial() {
      const stores = setupStore(['city'])

      try {
        const response = await api.filial.getFilialList({
          include: [
            'city',
            'lounges',
          ],
          filter: {
            city_id: stores.city.selectedCity.id,
            lounge_is_active: true,
          },
        })
        this.filialList = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
