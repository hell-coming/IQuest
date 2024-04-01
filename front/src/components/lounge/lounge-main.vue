<script setup lang="ts">
import Button from '../shared/button.vue'
import RoomsFilter from './rooms-filter.vue'
import BookingModal from './booking-modal.vue'
import Back from '#/components/shared/back.vue'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import type { ResultModal } from '#/types/shared/common'
import People from '#/assets/svg/shared/people.svg?component'
import Price from '#/assets/svg/shared/cash.svg?component'
import ResultModalDialog from '#/components/shared/result-modal.vue'

const stores = setupStore(['filialList'])

const activeFilialId = ref(stores.filialList.getFirstLounge?.id)

const activeRoomId = ref(stores.filialList.getFirstRoom?.id)

watch(activeFilialId, (newFilialId) => {
  const newRoomId = stores.filialList.filialList
    .find(({ id }) => id === newFilialId)?.lounges[0]?.id
  if (newRoomId)
    activeRoomId.value = newRoomId
})

const activeFilial = computed(() => {
  return stores.filialList.filialList
    .find(({ id }) => id === activeFilialId.value)
})

const activeRoom = computed(() => {
  if (!activeFilial.value)
    return null
  return activeFilial.value.lounges
    .find(({ id }) => id === activeRoomId.value)
})

const bookingModal = ref(false)
const resultModal = ref(false)
const isSuccessBooking = ref()

function openBookingModal() {
  bookingModal.value = true
}

function openResultModal(isSuccess: ResultModal) {
  isSuccessBooking.value = isSuccess
  resultModal.value = true
}
</script>

<template>
  <div class="block">
    <Back />
    <div class="block-container">
      <div class="img-container">
        <img :key="activeRoom?.cover" v-lazy-src="activeRoom?.cover" class="loading-lazy" alt="">
      </div>

      <div class="wrapper">
        <div class="wrapper-header">
          <h1>Лаунж зона</h1>
          <div class="filter-chips">
            <div class="filter">
              <template
                v-for="item in stores.filialList.filialList"
                :key="item.address"
              >
                <FilterChip
                  v-if="item.lounges.length > 0"
                  :is-selected="activeFilialId === item.id"
                  @click="activeFilialId = item.id"
                >
                  {{ item.address }}
                </FilterChip>
              </template>
            </div>
          </div>
          <div class="wrapper-header__rooms">
            <span class="bodyBold">Комната:</span>
            <div class="filter">
              <RoomsFilter
                v-for="element in activeFilial?.lounges"
                :key="element.name"
                :is-selected="activeRoomId === element.id"
                @click="activeRoomId = element.id"
              >
                {{ element.name }}
              </RoomsFilter>
            </div>
          </div>
        </div>
        <div class="wrapper-content">
          <div class="wrapper-content__text">
            <span class="bodyBold">Описание</span>
            <p class="footnote" v-html="activeRoom?.description" />
          </div>
          <div class="wrapper-content__people">
            <People />
            <span class="footnote">до {{ activeRoom?.max_people }} человек</span>
          </div>
        </div>
        <div class="wrapper-footer">
          <div class="wrapper-footer__price">
            <Price />
            <span class="footnote">
              {{ activeRoom?.price_per_half_hour }}₽/30 мин •
              {{ activeRoom?.price_per_hour }}₽/60 мин
            </span>
          </div>
          <Button :button-light="true" name="Оформить заявку" @click="openBookingModal" />
        </div>
      </div>

      <BookingModal
        v-model="bookingModal"
        :lounge="activeRoom!"
        @submit="openResultModal"
      />
      <ResultModalDialog
        v-model="resultModal"
        :is-success="isSuccessBooking"
      />
    </div>
  </div>
</template>

<style scoped lang="scss">
.block {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
  width: 100%;

  &-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    width: 100%;
    gap: $cover-64;

    @media screen and (max-width: 1024px) {
      display: flex;
      flex-direction: column;
      gap: $cover-16;
    }
  }
}
.img-container {
  overflow: hidden;
  border-radius: $cover-12;
  height: clamp(324px, 50vw, 568px);

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  @media screen and (max-width: 1024px) {
    width: 100%;
  }
}

.filter {
  flex-wrap: wrap;
  display: flex;
  align-items: flex-start;
  align-content: flex-start;
  gap: clamp($cover-12, 3vw, $cover-16);
  max-width: -moz-available;
  max-width: -webkit-fill-available;
  overflow: auto;

  @media screen and (max-width: 1024px) {
    flex-wrap: nowrap;
  }

  &-chips {
    display: flex;
    align-items: flex-start;
  }
}

.wrapper {
  width: 100%;
  max-width: 600px;
  display: flex;
  flex-direction: column;
  gap: clamp($cover-32, 3vw, $cover-64);
  align-items: flex-start;

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-32;
    max-width: inherit;

    &__rooms {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
    }
  }

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-24;

    &__text {
      display: flex;
      flex-direction: column;
      gap: $cover-12;
    }

    &__people {
      display: flex;
      gap: $cover-12;
      align-items: center;

      @media screen and (max-width: 1024px) {
        :deep(svg) {
          transform: scale(0.875);
        }
      }
    }
  }

  &-footer {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding: clamp($cover-16, 3vw, $cover-24);
    gap: $cover-24;
    border-radius: $cover-12;
    background-color: $color-opacity004;

    &__price {
      display: flex;
      align-items: center;
      gap: clamp($cover-8, 2vw, $cover-16);

      @media screen and (max-width: 1024px) {
        :deep(svg) {
          transform: scale(0.875);
        }
      }
    }

    @media screen and (max-width: 1024px) {
      border: 1px solid $color-opacity004;
      background: $color-base1-opacity04;
      gap: $cover-12;
      position: sticky;
      backdrop-filter: blur(24px);
      bottom: 16px;
      right: 0;
      z-index: 10;
    }
  }

  @media screen and (max-width: 1024px) {
    max-width: 100%;
  }
}
</style>
