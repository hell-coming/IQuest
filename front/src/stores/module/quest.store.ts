import { defineStore } from 'pinia'
import type { Quest } from '#/types/models/quest'
import type QuestBooking from '#/components/quest-view/booking/booking.vue'

//* --- State ----------------------------------------------- *//
interface QuestState {
  quest: Quest | null
  error: unknown
  toLight: boolean
  questBookingEl: typeof QuestBooking | null
}

//* --- Store ----------------------------------------------- *//
export const useQuestStore = defineStore('quest', {
  state: (): QuestState => ({
    questBookingEl: null,
    quest: null,
    toLight: false,
    error: {},
  }),
  actions: {
    async fetchQuest(id: string) {
      const stores = setupStore(['city'])
      try {
        const response = await api.quest.getQuest(id, {
          include: ['type', 'genre', 'filial', 'images', 'age_limit'],
          filter: {
            city_id: stores.city.selectedCity.id,
            is_active: true,
          },
        })
        this.quest = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
    scrollToQuestBooking() {
      const top = this.questBookingEl!.$el.offsetTop
      window.scrollTo({ left: 0, top: top - 100, behavior: 'smooth' })
      setTimeout(() => this.toLight = true, 150)
      setTimeout(() => this.toLight = false, 1000)
    },
  },
})
