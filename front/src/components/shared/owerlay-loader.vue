<script setup lang="ts">
import { LottieAnimation } from 'lottie-web-vue'
import WatermelonJSON from '#/assets/animation/animate.json'
</script>

<template>
  <LottieAnimation

    :animation-data="WatermelonJSON"
    :loop="true"
    :auto-play="true"
    :speed="1"
  />
</template>

<style>
svg {
  transform: translate3d(0) !important;
}
</style>
