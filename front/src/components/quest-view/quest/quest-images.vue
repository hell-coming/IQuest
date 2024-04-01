<script setup lang="ts">
import 'swiper/css/bundle'
import '#/assets/scss/swiper.scss'

import Swiper from 'swiper'
import { onMounted, ref } from 'vue'
import {
  Autoplay,
  Navigation,
  Pagination,
} from 'swiper/modules'
import type { SwiperOptions } from 'swiper/types'
import Next from '#/assets/svg/shared/swiper-next.svg?component'
import Prev from '#/assets/svg/shared/swiper-prev.svg?component'

defineProps<{
  images?: {
    image: string
  }[]
}>()

const stores = setupStore('quest')

const slider = ref<HTMLElement | null>(null)
const swiperOptions: SwiperOptions = {
  direction: 'horizontal',
  slidesPerView: 1,
  speed: 850,
  spaceBetween: 10,
  loop: true,

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  modules: [Navigation, Pagination, Autoplay],
}

onMounted(() => {
  if (slider.value) {
    // eslint-disable-next-line no-new
    new Swiper(slider.value, swiperOptions)
  }
})
</script>

<template>
  <div ref="slider" class="swiper-container">
    <div class="swiper-wrapper">
      <template v-if="images && images.length > 0">
        <img
          v-for="img in images"
          :key="img.image"
          v-lazy-src="img.image"
          class="swiper-slide loading-lazy"
          alt=""
        >
      </template>
      <template v-else>
        <img :key="stores.quest?.cover" v-lazy-src="stores.quest?.cover" class="loading-lazy" alt="">
      </template>
    </div>

    <button class="swiper-button-prev swiper-button">
      <Prev />
    </button>
    <button class="swiper-button-next swiper-button">
      <Next />
    </button>
    <div class="swiper-pagination__wrapper">
      <div class="swiper-pagination" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.swiper-container {
  overflow: hidden;
  position: relative;

  width: 100%;
  height: 411px;

  @media screen and (max-width: 600px) {
    height: 229px;
  }
}
.swiper-slide {
  border-radius: $cover-8;
}
.swiper-pagination {
  display: flex;
  bottom: clamp(8px, 2vw, 12px);
  left: 0;

  &__wrapper {
    margin: 0 auto;
    display: flex;
    justify-content: center;
    position: relative;
    width: 272px;
  }
}
.swiper-wrapper {
  img {
    border-radius: $cover-12;
    object-fit: cover;
    height: 100%;
    width: 100%;
  }
}
</style>
