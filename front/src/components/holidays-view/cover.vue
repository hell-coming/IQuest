<script setup lang="ts">
import BookingModal from '#/components/holidays-view/corporative/modal/booking-modal.vue'
import ResultModalDialog from '#/components/shared/result-modal.vue'

import Button from '#/components/shared/button.vue'
import type { ResultModal } from '#/types/shared/common'

export interface Props {
  type: string
  corpInfo?: boolean
}
defineProps<Props>()

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
  <div class="cover" :class="{ 'corp-cover': type === 'Корпоратив' }">
    <div
      class="cover-container"
      :class="{
        man: type === 'Взрослый праздник',
        child: type === 'Детский праздник',
        corp: type === 'Корпоратив',
      }"
    >
      <div class="container cover-info" :class="{ corpInfo }">
        <h1>{{ type }}</h1>
        <div v-if="corpInfo" class="cover-info__btn">
          <Button :button-light="true" name="Оформить заявку" @click="openBookingModal" />
          <span class="body">От 600₽ с человека</span>
        </div>
        <BookingModal
          v-model="bookingModal"
          @submit="openResultModal"
        />
        <ResultModalDialog
          v-model="resultModal"
          :is-success="isSuccessBooking"
        />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.corp-cover {
  @media screen and (max-width: 500px) {
    max-height: 191px;
  }
}

.cover {
  margin-top: 88px;
  height: clamp(304px, 40vw, 555px);
  position: relative;

  &-container,
  .man,
  .child,
  .corp {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: flex-end;
  }

  &-info {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: $cover-32;
    z-index: 2;
    margin-bottom: clamp($cover-64, 20vw, 108px);

    &__btn {
      display: flex;
      max-width: 545px;
      align-items: center;
      gap: $cover-16;

      div {
        max-width: 295px;
      }

      @media screen and (max-width: 600px) {
        display: none;
      }
    }
  }

  @media screen and (max-width: 1024px) {
    margin-top: 0;
  }
}

.corpInfo {
  margin-bottom: 52px;
}

.man {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/man.webp'),
    lightgray 50% / cover no-repeat;
}

.child {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/child.webp'),
    lightgray 50% / cover no-repeat;
}

.corp {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/corp.webp') no-repeat;
}

.corp {
  @media screen and (max-width: 500px) {
    background-position: center 10px !important;
  }
}
</style>
