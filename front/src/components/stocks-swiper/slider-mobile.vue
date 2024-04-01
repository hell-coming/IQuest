<script setup lang="ts">
import type { Stocks } from '#/types/models/stocks'
import Gift from '#/assets/svg/shared/gift.svg?url'

defineProps<{ salse: Stocks }>()
</script>

<template>
  <div class="baner-swiper">
    <img :src="Gift">
    <span class="footnote">
      {{ salse.name }}
      {{ salse.description }}
    </span>
  </div>
</template>

<style scoped lang="scss">
.baner-swiper {
  display: flex;
  align-items: center;
  width: 100%;
  height: 100%;
  max-width: 318px;
  border: 1px solid $color-opacity012;
  border-radius: $cover-8;
  padding: $cover-16;
  gap: $cover-12;
}
</style>
