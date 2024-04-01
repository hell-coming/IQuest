<script setup lang="ts">
import Swiper from 'swiper'

import 'swiper/css/bundle'
import '#/assets/scss/swiper.scss'

import type { SwiperOptions } from 'swiper/types'
import SliderMobileVue from './slider-mobile.vue'

const stores = setupStore('stocks')

const slider = ref<HTMLElement | null>(null)
const swiperOptions: SwiperOptions = {
  direction: 'horizontal',
  spaceBetween: 8,
  speed: 800,
  slidesPerView: 'auto', // Определяет сколько слайдов отображается одновременно
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
    <div ref="slider" class="swiper-container container">
      <div class="swiper-wrapper">
        <SliderMobileVue
          v-for="item in stores.stocks"
          :key="item.id"
          :salse="item"
          class="swiper-slide"
        />
      </div>
    </div>
  </template>
</template>

<style scoped lang="scss">
.swiper-container {
  display: none;
  overflow: hidden;
  position: relative;
  max-height: 316px;
}

.swiper-wrapper {
  height: auto;
}
</style>
