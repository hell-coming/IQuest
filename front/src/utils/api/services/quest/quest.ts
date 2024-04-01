import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchQuestsRequest, SearchScheduleQuestsRequest } from './quest.types'
import type { Quest } from '#/types/models/quest'

export default (instance: AxiosInstance) => ({
  getSearch(payload: SearchQuestsRequest): AxiosPromise<{ data: Quest[] }> {
    return instance.post('/quests:search', payload)
  },

  getQuest(id: string, params: SearchQuestsRequest): AxiosPromise<{ data: Quest }> {
    return instance.get(`/quests/${id}`, { params })
  },
  getScheduleQuest(payload: SearchScheduleQuestsRequest, signal?: AbortController['signal']): AxiosPromise<{ data: any }> {
    return instance.post('/schedule_quests:search', payload, { signal })
  },
})
