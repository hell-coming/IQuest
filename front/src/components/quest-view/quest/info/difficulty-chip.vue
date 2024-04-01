<script setup lang="ts">
import IconFilled from '#/assets/svg/shared/IconFilled.svg?url'
import IconNoneFilled from '#/assets/svg/shared/IconNoneFilled.svg?url'

defineProps<{ max: number }>()
</script>

<template>
  <span>
    <img
      v-for="i in 3"
      :key="i"
      :src="i > max ? IconNoneFilled : IconFilled"
    >
  </span>
</template>

<style scoped lang="scss">
span {
  display: flex;
  gap: $cover-4;
}
img {
  width: clamp(18px, 5vw, 24px);
}
</style>
