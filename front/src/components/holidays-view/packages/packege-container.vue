<script setup lang="ts">
import BookingModal from '../booking-modal.vue'
import PackageIncludes from './package-includes.vue'
import type { Packages } from '#/types/models/holiday'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import Button from '#/components/shared/button.vue'
import ResultModalDialog from '#/components/shared/result-modal.vue'
import type { ResultModal } from '#/types/shared/common'
import DetailsContainer from '#/components/holidays-view/details/datails-container.vue'
import Price from '#/assets/svg/shared/cash.svg?url'

const stores = setupStore(['holiday'])

const activePackegeId = ref(stores.holiday.getFirstPackegs?.id)

const activePackege = computed(() => {
  return stores.holiday.holiday?.packages
    .find(item => item.id === activePackegeId.value) as Packages
})

const bookingModal = ref(false)
const resultModal = ref(false)
const isSuccessBooking = ref()

const sort = stores.holiday.holiday?.packages.sort((a, b) => a.sequence_number - b.sequence_number)
function openBookingModal() {
  bookingModal.value = true
}

function openResultModal(isSuccess: ResultModal) {
  isSuccessBooking.value = isSuccess
  resultModal.value = true
}
</script>

<template>
  <div class="wrapper">
    <section class="container">
      <div v-if="activePackege" class="booking">
        <div class="booking-header">
          <h2>Пакет</h2>
          <div class="filter">
            <template v-for="item in sort" :key="item.name">
              <FilterChip
                :is-selected="activePackegeId === item.id"
                @click="activePackegeId = item.id"
              >
                {{ item.name }}
              </FilterChip>
            </template>
          </div>
          <PackageIncludes :description="activePackege.description" />
          <div class="booking-footer">
            <Button
              :button-light="true"
              name="Оформить заявку"
              @click="openBookingModal"
            />
            <span class="body">От {{ activePackege.price }}₽</span>
          </div>
        </div>
      </div>
    </section>
    <DetailsContainer />
    <div v-if="activePackege" class="footer-btn">
      <Button
        :button-light="true"
        name="Оформить заявку"
        @click="openBookingModal"
      />
      <div class="footer-btn__price">
        <img :src="Price">
        <span class="body">От {{ activePackege.price }}₽</span>
      </div>
    </div>
    <BookingModal
      v-model="bookingModal"
      :package="activePackege"
      @submit="openResultModal"
    />
    <ResultModalDialog
      v-model="resultModal"
      :is-success="isSuccessBooking"
    />
  </div>
</template>

<style scoped lang="scss">
.booking {
  width: 100%;
  height: 100%;
  gap: $cover-64;
  border-radius: $cover-16;
  padding: $cover-48;
  background-color: $color-opacity004;

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-32;

    .filter {
      display: flex;
      overflow: auto;
      gap: $cover-16;
    }
  }

  &-schedule {
    display: flex;
    flex-direction: column;
    gap: $cover-64;
  }

  &-footer {
    align-items: center;
    display: flex;
    gap: $cover-24;

    div {
      max-width: 309px;
    }

    @media screen and (max-width: 600px) {
      display: none;
    }
  }

  @media screen and (max-width: 1024px) {
    padding: $cover-24 $cover-16;
  }

  @media screen and (max-width: 600px) {
    border-radius: 0;
  }
}

.footer-btn {
  display: none;
  flex-direction: column-reverse;
  position: sticky;
  bottom: 20px;
  z-index: 10;

  padding: $cover-16;
  justify-content: center;
  align-items: flex-start;
  gap: $cover-12;

  border-radius: 14px;
  border: 1px solid $color-opacity004;
  background: $color-base1-opacity04;
  backdrop-filter: blur($cover-24);

  div {
    max-width: 100%;
  }

  span {
    color: $color-opacity06;
  }

  &__price {
    display: flex;
    align-items: center;
    gap: $cover-8;

    img {
      width: clamp(26px, 5vw, $cover-32);
    }
  }
}

@media screen and (max-width: 600px) {
  .container:nth-child(1) {
    padding: 0;
  }

  .footer-btn {
    display: flex;
    margin-inline: $cover-16;
  }
}
</style>
