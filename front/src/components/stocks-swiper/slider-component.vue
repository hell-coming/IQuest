<script setup lang="ts">
import type { Stocks } from '#/types/models/stocks'

defineProps<{ salse: Stocks }>()
</script>

<template>
  <div class="baner-swiper">
    <div class="baner-swiper__body">
      <div class="baner-swiper__body-text">
        <h1>{{ salse.name }}</h1>
        <p class="body">
          {{ salse.description }}
        </p>
      </div>
    </div>
    <div class="baner-swiper__image">
      <div class="baner-front">
        <img v-lazy-src="salse.front_image" class="loading-lazy" alt="">
      </div>
      <div class="baner-back">
        <img v-lazy-src="salse.back_image" class="loading-lazy" alt="">
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.baner-swiper {
  display: flex;
  justify-content: space-between;
  width: 100%;

  &__body {
    display: flex;
    margin-top: 48px;

    &-text {
      display: flex;
      flex-direction: column;
      gap: $cover-12;
      max-width: clamp(350px, 45vw, 600px);
    }

    &-controler {
      display: flex;
      align-items: center;
    }
  }

  &__image {
    display: flex;
    position: relative;
  }
}

.baner {
  &-front {
    position: absolute;
    right: 174px;
    top: 22px;
    z-index: 1;
    width: clamp(250px, 25vw, 364px);
    height: 310px;
    display: flex;
    transform: rotate(-8deg);
    padding: 12px 12px 68px 12px;
    border-radius: $cover-8;
    border: 1px solid $color-base1-opacity025;
    background: $color-base2;
  }

  &-back {
    margin-top: 71px;
    width: clamp(220px, 25vw, 321px);
    height: 272px;
    display: flex;
    transform: rotate(4deg);
    padding: 10px 10px 59px 10px;
    border-radius: $cover-8;
    border: 1px solid $color-base1-opacity025;
    background: $color-base2;
  }
}

img {
  width: 100%;
  object-fit: cover;
  border-radius: $cover-4;
}

.element {
  display: flex;
  width: 100%;
  height: 6px;
  border-radius: $cover-2;
  background-color: $color-opacity004;

  &-container {
    min-width: 192px;
    display: flex;
    gap: $cover-8;
  }
}
</style>
