import { useGlobalStore } from './common/global.store'
import { useQuestStore } from './module/quest.store'
import { useQuestListStore } from './module/quest-list.store'
import { useScheduleQuestStore } from './module/schedule.store'
import { useStocksStore } from './module/stocks.store'
import { useServicesStore } from './module/services.store'
import { useHolidaysListStore } from './module/holidays-list.store'
import { useHolidayStore } from './module/holiday.store'
import { useFilialListStore } from './module/lounge.store'
import { useCertificateListStore } from './module/certificate.store'
import { useCityStore } from './module/city.store'
import { useContactStore } from './module/contacts.store'

type ExtractStoreId<T> = T extends { $id: infer U } ? U : never

interface IStoreTypes {
  global: ReturnType<typeof useGlobalStore>
  city: ReturnType<typeof useCityStore >
  quest: ReturnType<typeof useQuestStore>
  questList: ReturnType<typeof useQuestListStore>
  scheduleQuest: ReturnType<typeof useScheduleQuestStore>
  stocks: ReturnType<typeof useStocksStore>
  services: ReturnType<typeof useServicesStore>
  holidaysList: ReturnType<typeof useHolidaysListStore>
  holiday: ReturnType<typeof useHolidayStore>
  filialList: ReturnType<typeof useFilialListStore>
  сertificateList: ReturnType<typeof useCertificateListStore>
  contact: ReturnType<typeof useContactStore >
}

type StoreKeys = ExtractStoreId<IStoreTypes[keyof IStoreTypes]>

export const stores: Readonly<{ [K in StoreKeys]: () => IStoreTypes[K] }> = Object.freeze({
  global: useGlobalStore,
  city: useCityStore,
  quest: useQuestStore,
  questList: useQuestListStore,
  scheduleQuest: useScheduleQuestStore,
  stocks: useStocksStore,
  services: useServicesStore,
  holidaysList: useHolidaysListStore,
  holiday: useHolidayStore,
  filialList: useFilialListStore,
  сertificateList: useCertificateListStore,
  contact: useContactStore,
})

function setupStore<T extends StoreKeys>(key: T): Readonly<IStoreTypes[T]>
function setupStore<T extends StoreKeys>(keys: T[]): Readonly<{ [K in T]: IStoreTypes[K]; }>
function setupStore<T extends StoreKeys>(keysOrKey: T[] | T) {
  if (Array.isArray(keysOrKey))
    return Object.fromEntries(keysOrKey.map(key => [key, stores[key]()])) as { [K in T]: IStoreTypes[K] }

  return stores[keysOrKey]()
}

export { setupStore }
