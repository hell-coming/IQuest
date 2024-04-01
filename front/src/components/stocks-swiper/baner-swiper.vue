<script setup lang="ts">
import Swiper from 'swiper'

import 'swiper/css/bundle'
import '#/assets/scss/swiper.scss'

import {
  Autoplay,
  EffectCreative,
  Navigation,
  Pagination,
} from 'swiper/modules'
import type { SwiperOptions } from 'swiper/types'
import SliderComponent from '#/components/stocks-swiper/slider-component.vue'

const stores = setupStore('stocks')

const slider = ref<HTMLElement | null>(null)
const swiperOptions: SwiperOptions = {
  direction: 'vertical',

  slidesPerView: 1,
  spaceBetween: 500,
  speed: 850,
  loop: true,
  autoplay: {
    delay: 10000, // Задержка перед сменой слайдов
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },

  creativeEffect: {
    prev: {
      translate: [0, 1000, 0],
    },
    next: {
      translate: [0, 1000, 0],
    },
  },
  allowTouchMove: false,
  effect: 'creative',
  modules: [Navigation, Pagination, Autoplay, EffectCreative],
}

onMounted(() => {
  if (slider.value && stores.stocks) {
    // eslint-disable-next-line no-new
    new Swiper(slider.value, swiperOptions)
  }
})
</script>

<template>
  <template v-if="stores.stocks?.length">
    <section class="bag-secondary">
      <div ref="slider" class="swiper-container container">
        <div class="swiper-wrapper">
          <SliderComponent
            v-for="item in stores.stocks"
            :key="item.id"
            :salse="item"
            class="swiper-slide"
          />
        </div>

        <button class="swiper-button-prev swiper-button">
          <svg
            width="40"
            height="40"
            viewBox="0 0 40 40"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M16 28L8 20L16 12"
              stroke="white"
              stroke-opacity="0.75"
              stroke-width="2"
              stroke-linecap="square"
              stroke-linejoin="round"
            />
          </svg>
        </button>
        <button class="swiper-button-next swiper-button">
          <svg
            width="40"
            height="40"
            viewBox="0 0 40 40"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M24 12L32 20L24 28"
              stroke="white"
              stroke-opacity="0.75"
              stroke-width="2"
              stroke-linecap="square"
              stroke-linejoin="round"
            />
          </svg>
        </button>
        <div class="swiper-pagination" />
      </div>
    </section>
  </template>
  <template v-else>
    <div class="plug" />
  </template>
</template>

<style scoped lang="scss">
.bag-secondary {
  background-image: url(/gradient/baner-gradient.svg);
  background-repeat: no-repeat;
  background-position: center top;
  overflow: hidden;
}

.swiper-container {
  overflow: hidden;
  position: relative;
  max-height: 316px;
}

.swiper-button {
  top: 260px;

  &.swiper-button-prev {
    left: auto;
  }

  &.swiper-button-next {
    left: 22%;
  }
}

.swiper-pagination {
  left: 9%;
  right: auto;
  top: 260px;
  max-width: clamp(140px, 13vw, 192px);
  width: 100%;
  display: flex;
  gap: $cover-8;
}
</style>
