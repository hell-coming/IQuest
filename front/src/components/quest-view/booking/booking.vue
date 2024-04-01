<script setup lang="ts">
import { onMounted } from 'vue'
import FilterChip from './chips/filter-chip.vue'
import ScheduleContainer from './schedule-container.vue'
import Datepicker from '#/components/shared/datepicker.vue'
import type { SearchScheduleQuestsRequest } from '#/utils/api/services/quest/quest.types'

type Filter = SearchScheduleQuestsRequest['filter']

const props = defineProps<{ idQuest: number }>()

enum Chip {
  Today = 'Сегодня',
  Tommorow = 'Завтра',
  Weekend = 'Эти выходные',
  SelectDate = 'Выбрать даты',
}

const stores = setupStore(['scheduleQuest', 'quest'])

const filters = [
  { name: Chip.Today, params: { today: true } },
  { name: Chip.Tommorow, params: { tomorrow: true } },
  { name: Chip.Weekend, params: { weekend: true } },
]
const defaultChip = filters[0]

const selectedChip = ref(defaultChip.name)

async function select(name: Chip, params: Omit<Filter, 'quest_id'>) {
  selectedChip.value = name

  const filter = { ...params, quest_id: props.idQuest } as Filter

  await stores.scheduleQuest.fetchScheduleQuest(filter)
}

onMounted(() => select(defaultChip.name, defaultChip.params))
</script>

<template>
  <section class="container">
    <div class="booking" :class="{ toLight: stores.quest.toLight }">
      <div class="booking-header">
        <h2>Расписание</h2>
        <div class="filter">
          <FilterChip
            v-for="item in filters"
            :key="item.name"
            :is-selected="selectedChip === item.name"
            @click="select(item.name, item.params)"
          >
            {{ item.name }}
          </FilterChip>

          <FilterChip :is-selected="selectedChip === Chip.SelectDate">
            <Datepicker
              @select="(value) => select(Chip.SelectDate, { between: value })"
              @open="selectedChip = Chip.SelectDate"
            />
          </FilterChip>
        </div>
      </div>
      <div class="booking-schedule">
        <ScheduleContainer
          v-for="item in stores.scheduleQuest.scheduleQuest"
          :key="item.id"
          :date-times="item"
        />
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.booking {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  gap: clamp($cover-40, 3vw, $cover-64);
  border-radius: $cover-16;
  padding: $cover-48;
  background-color: $color-opacity004;
  transition: background-color 0.3s ease;

  &-header {
    display: flex;
    flex-direction: column;
    gap: clamp($cover-16, 3vw, $cover-32);
    .filter {
      display: flex;
      gap: clamp($cover-8, 2vw, $cover-16);

      @media screen and (max-width: 1024px) {
        overflow: auto;
      }
    }
  }

  &-schedule {
    display: flex;
    flex-direction: column;
    gap: clamp($cover-40, 3vw, $cover-64);
  }

  @media screen and (max-width: 600px) {
    padding: $cover-24 $cover-16;
  }
}

@media screen and (max-width: 1024px) {
  .booking {
    border-radius: 0;
  }
  .container {
    padding: 0;
  }
}

.toLight {
  background-color: $color-opacity012;
}
</style>
