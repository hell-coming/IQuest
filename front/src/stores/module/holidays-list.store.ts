import { defineStore } from 'pinia'
import type { Holiday } from '#/types/models/holiday'

//* --- State ----------------------------------------------- *//
interface HolidaysListState {
  holidaysList: Holiday[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useHolidaysListStore = defineStore('holidaysList', {
  state: (): HolidaysListState => ({
    holidaysList: [],
    error: {},
  }),
  actions: {
    async fetchHolidaysList() {
      try {
        const response = await api.holidays.getHolidaysList({
          include: ['packages'],
          filter: {
            is_active: true,
          },
        })
        this.holidaysList = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },
})
