<script setup lang="ts">
import ArrowBack from '#/assets/svg/shared/arrow-back.svg?component'
import router from '#/router'

function goBack() {
  router.go(-1)
}
</script>

<template>
  <div class="footnote pointer back" @click="goBack()">
    <ArrowBack />
    <span>назад</span>
  </div>
</template>

<style scoped lang="scss">
.back {
  width: max-content;
  display: flex;
  gap: $cover-4;
  align-items: flex-end;
  padding: 3px 0px 5px 0px;
  transition: all 0.3 ease-in-out;

  &:hover {
    color: $color-base2;

    :deep(svg) {
      path {
        stroke-opacity: 1;
      }
    }
  }
  @media screen and (max-width: 1024px) {
    display: none;
  }
}
</style>
