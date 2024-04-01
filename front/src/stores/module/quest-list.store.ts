import { defineStore } from 'pinia'
import type { Quest } from '#/types/models/quest'

//* --- State ----------------------------------------------- *//
interface QuestListState {
  questList: Quest[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useQuestListStore = defineStore('questList', {
  state: (): QuestListState => ({
    questList: [],
    error: {},
  }),
  actions: {
    async fetchQuests() {
      const stores = setupStore(['city'])
      try {
        const response = await api.quest.getSearch({
          include: ['type', 'genre'],
          filter: {
            city_id: stores.city.selectedCity.id,
            is_active: true,
          },
        })
        this.questList = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
