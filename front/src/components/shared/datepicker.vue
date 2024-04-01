<script setup lang="ts">
import VueDatePicker from '@vuepic/vue-datepicker'
import dayjs from 'dayjs'
import { useDisplay } from 'vuetify'

const emit = defineEmits<{ select: [value: string[] ] }>()
const selectedDate = ref<string[]>()

const { mdAndDown } = useDisplay()

function format(dates: Date[]) {
  return dates.map((date) => {
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')

    return `${day}.${month}`
  }).join(' - ')
}

watch(selectedDate, (value) => {
  if (value && value.length > 1)
    emit?.('select', value.map(value => dayjs(value).format('YYYY-MM-DD')))
})
</script>

<template>
  <VueDatePicker
    v-model="selectedDate"
    :teleport-center="mdAndDown"
    disable-year-select
    :clearable="false"
    placeholder="Выбрать даты"
    :auto-apply="true"
    locale="ru"
    :enable-time-picker="false"
    month-name-format="long"
    dark range week-num-name="We"
    :min-date="new Date()"
    :max-date="new Date(new Date().setDate(new Date().getDate() + 30))"
    :format="format"
  />
</template>

<style scoped lang="scss">
.selected {
  background-color: $color-primary;

  &:hover {
    background-color: $color-primary;
  }
}
</style>
