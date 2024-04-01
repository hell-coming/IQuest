<script setup lang="ts">
import Card from '../details/card.vue'
import Price from '#/assets/svg/shared/cash.svg?url'

import BookingModal from '#/components/holidays-view/corporative/modal/booking-modal.vue'
import ResultModalDialog from '#/components/shared/result-modal.vue'
import type { ResultModal } from '#/types/shared/common'
import Button from '#/components/shared/button.vue'

import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import CorporaivePlots from '#/components/holidays-view/corporative/corporaive-plots.vue'

const filterChip = ['Живой квест', 'Под ключ']

const activePackege = reactive({
  name: filterChip[0],
})

async function select(item: string) {
  activePackege.name = item
}

const detailsLiveQuest = [
  {
    icon: 'maskIcon',
    description: 'Живой квест - это детективная салонная игра, которая моделирует самые невероятные ситуации',
    footnote: true,
  },
  {
    icon: 'barIcon',
    description: 'Игра не требует беспрерывных действий, поэтому в процессе можно выпивать, есть и общаться',
    footnote: true,
  },
  {
    icon: 'teamIcon',
    description: 'В зависимости от сюжета одновременно могут играть от 8 до 30 человек',
    footnote: true,
  },
]

const detailsKeys = [
  {
    icon: 'fluent',
    description: 'Мы готовы воплотить в жизнь любую идею для вашего корпоратива: подвижный, спокойный , тематический и тд.',
    footnote: true,
  },
  {
    icon: 'rishake',
    description: 'Основная ваша задача это прийти к нам, а дальше мы подберем лучший вариант именно для вашей компании и возьмем все организационные моменты на себя.',
    footnote: true,
  },
]

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
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Пакет</h2>
        <div class="booking-info">
          <div class="filter">
            <FilterChip
              v-for="item in filterChip"
              :key="item"
              :is-selected="activePackege.name === item"
              @click="select(item)"
            >
              {{ item }}
            </FilterChip>
          </div>
          <div class="booking-details" :class="{ 'column-gap': activePackege.name === 'Под ключ' }">
            <Card v-for="item in detailsLiveQuest" v-show="activePackege.name === 'Живой квест'" :key="item.icon" :item="item" />
            <Card v-for="item in detailsKeys" v-show="activePackege.name === 'Под ключ'" :key="item.icon" :item="item" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <CorporaivePlots v-show="activePackege.name === 'Живой квест'" />
  <div class="footer-btn">
    <Button
      :button-light="true"
      name="Оформить заявку"
      @click="openBookingModal"
    />
    <div class="footer-btn__price">
      <img :src="Price">
      <span class="body">От 600₽ с человека</span>
    </div>
  </div>
  <BookingModal
    v-model="bookingModal"
    @submit="openResultModal"
  />
  <ResultModalDialog
    v-model="resultModal"
    :is-success="isSuccessBooking"
  />
</template>

<style scoped lang="scss">
.booking {
  margin-top: 56px;
  width: 100%;
  height: 100%;
  gap: $cover-64;

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-32;

    .filter {
      display: flex;
      flex-wrap: wrap;
      gap: $cover-16;
    }
  }

  &-info {
    display: flex;
    flex-direction: column;
    gap: $cover-64;
  }

  &-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    align-items: flex-start;
    align-content: flex-start;
    flex-wrap: wrap;
    gap: $cover-24;

    @media screen and (max-width: 1024px) {
      grid-template-columns: repeat(2, 1fr);

      .item:nth-child(3) {
        grid-column: 1 / 3;
      }
    }

    @media screen and (max-width: 768px) {
      grid-template-columns: repeat(1, 1fr);

      .item:nth-child(1) {
        grid-column: 1;
      }

      .item:nth-child(2) {
        grid-column: 1;
      }

      .item:nth-child(3) {
        grid-column: 1;
      }
    }
  }

  @media screen and (max-width: 600px) {
    margin-top: 40px;
  }
}

.column-gap {
  grid-template-columns: repeat(2, 1fr);

  @media screen and (max-width: 768px) {
    grid-template-columns: repeat(1, 1fr);
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

  @media screen and (max-width: 600px) {
    display: flex;
    margin-inline: $cover-16;
  }
}
</style>
