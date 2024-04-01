<script setup lang="ts">
import Button from '../shared/button.vue'
import BookingModal from './booking-modal.vue'
import type { Certificate } from '#/types/models/certificate'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import type { ResultModal } from '#/types/shared/common'
import ResultModalDialog from '#/components/shared/result-modal.vue'

const stores = setupStore(['сertificateList'])

const activePackegeId = ref(stores.сertificateList.getFirstCertificate?.id)

const activePackege = computed(() => {
  return stores.сertificateList.сertificateList
    .find(({ id }) => id === activePackegeId.value) as Certificate
})

const info = [
  { name: 'Есть доставка', icon: 'delivery' },
  { name: 'Сертификат оформляется на сумму от 500₽', icon: 'gift' },
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
  <div class="block">
    <div class="img-container">
      <img :key="activePackege.cover" v-lazy-src="activePackege.cover" class="loading-lazy" alt="">
    </div>
    <div class="wrapper">
      <div class="wrapper-header">
        <h1>Сертификат</h1>
        <div class="wrapper-header__content">
          <div class="wrapper-header__filter">
            <span class="body">Выберите упаковку:</span>
            <div class="filter">
              <FilterChip
                v-for="item in stores.сertificateList.сertificateList"
                :key="item.name"
                :is-selected="activePackegeId === item.id"
                @click="activePackegeId = item.id"
              >
                {{ item.name }}
              </FilterChip>
            </div>
          </div>
          <span class="body">Стоимость упаковки — {{ activePackege.price }}₽</span>
        </div>
      </div>
      <div class="wrapper-content">
        <span class="bodyBold">Описание</span>
        <p class="footnote" v-html="activePackege.description " />
      </div>
      <div class="wrapper-footer">
        <div class="wrapper-footer__info">
          <div v-for="item in info" :key="item.name" class="wrapper-footer__item">
            <img :src="`/icons/share/${item.icon}.svg`" alt="">
            <span class="footnote">{{ item.name }}</span>
          </div>
        </div>
        <Button :button-light="true" name="Оформить заявку" @click="openBookingModal" />
      </div>
    </div>
    <BookingModal
      v-model="bookingModal"
      :certificate="activePackege"
      @submit="openResultModal"
    />
    <ResultModalDialog
      v-model="resultModal"
      :is-success="isSuccessBooking"
    />
  </div>
</template>

<style scoped lang="scss">
.block {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: $cover-64;
  width: 100%;

  @media screen and (max-width: 1024px) {
    display: flex;
    flex-direction: column;
    gap: $cover-16;
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

    &__content {
      display: flex;
      flex-direction: column;
      gap: $cover-24;
    }

    &__filter {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: $cover-16;

      .body {
        color: $color-opacity06;
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
      }
    }

    @media screen and (max-width: 1024px) {
      max-width: inherit;
    }
  }

  &-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: $cover-12;
  }

  &-footer {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding: clamp($cover-16, 3vw, $cover-24);
    gap: $cover-24;
    border-radius: $cover-12;
    background-color: $color-opacity004;

    &__info {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: $cover-12;
    }

    &__item {
      display: flex;
      align-items: center;
      gap: clamp($cover-8, 2vw, $cover-12);

      @media screen and (max-width: 1024px) {
        img {
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
