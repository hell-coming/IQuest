<script setup lang="ts">
import { useDisplay } from 'vuetify'
import Chip from './assist-chip.vue'
import Difficulty from './difficulty-chip.vue'
import Address from '#/components/shared/address.vue'
import PhoneNumber from '#/components/shared/phone-number.vue'
import Button from '#/components/shared/button.vue'
import type { Quest } from '#/types/models/quest'

const props = defineProps<{ info: Quest }>()
const { xs } = useDisplay()
const button = 'Забронировать'
const stores = setupStore(['quest'])

const convertDuration = computed(() => {
  if (props.info.duration > 60) {
    const hours = Math.floor(props.info.duration / 60)
    const minutes = props.info.duration % 60

    if (minutes === 0)
      return `${hours} ч`

    return `${hours} ч ${minutes} мин`
  }
  else {
    return `${props.info.duration} мин`
  }
})

const chips = computed(() => {
  const {
    type,
    genre,
    age_limit,
    level,
    min_people,
    max_people,
  } = props.info

  return [
    { title: `${type.name}` },
    { title: `${genre.name}` },
    { title: `${age_limit?.name}` },
    {
      title: `Сложность`,
      slot: {
        is: Difficulty,
        props: { max: level },
      },
    },
    { title: `${min_people} - ${max_people} игроков` },
    { title: `${convertDuration.value}` },
  ]
})

const { scrollToQuestBooking } = stores.quest
</script>

<template>
  <div class="info">
    <div class="info-container">
      <h1>{{ info.name }}</h1>
      <div class="info-contacts d-flex">
        <PhoneNumber :is-active-link="xs" :is-active-img="xs" />
        <Address :is-active-img="xs" :is-active-link="xs" :address="info.filial" />
      </div>
      <div class="info-details">
        <Chip v-for="item in chips" :key="item.title" :name="item.title">
          <component
            v-bind="item.slot?.props"
            :is="item.slot?.is"
          />
        </Chip>
      </div>
    </div>
    <Button :name="button" :button-light="true" @click="scrollToQuestBooking" />
  </div>
</template>

<style scoped lang="scss">
.info {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &-container {
    display: flex;
    flex-direction: column;
    gap: clamp($cover-24, 4vw, $cover-32);
  }

  &-contacts {
    gap: $cover-32;

    @media screen and (max-width: 600px) {
      flex-direction: column-reverse;
      gap: $cover-12;
    }
  }

  &-details {
    display: flex;
    flex-wrap: wrap;
    gap: clamp($cover-12, 5vw, $cover-16);
  }
}
</style>
