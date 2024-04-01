import { defineStore } from 'pinia'
import type { Schedule } from '#/types/models/schedule'
import type { SearchScheduleQuestsRequest } from '#/utils/api/services/quest/quest.types'

//* --- State ----------------------------------------------- *//
interface ScheduleQuestState {
  scheduleQuest: Schedule[]
  error: unknown
  abortController: AbortController
}

//* --- Store ----------------------------------------------- *//
export const useScheduleQuestStore = defineStore('scheduleQuest', {
  state: (): ScheduleQuestState => ({
    scheduleQuest: [],
    error: {},
    abortController: new AbortController(),
  }),
  actions: {
    async fetchScheduleQuest(filter: SearchScheduleQuestsRequest['filter']) {
      this.abortController.abort?.()
      this.abortController = new AbortController()

      try {
        const response = await api.quest.getScheduleQuest({
          include: ['timeslots'],
          filter,
        }, this.abortController.signal)
        this.scheduleQuest = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
