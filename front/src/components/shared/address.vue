<script setup lang="ts">
import Link from '#/assets/svg/shared/link-quest.svg?url'
import Pin from '#/assets/svg/icon/pin.svg?url'
import type { Filial } from '#/types/models/quest'

interface Props {
  address: Filial
  isActiveImg?: boolean
  isActiveLink?: boolean
}
const props = defineProps<Props>()

const url = `https://yandex.ru/maps/?&ll=${props.address.longitude},${props.address.latitude}&text=${encodeURIComponent('iQuest')}&z=17`
</script>

<template>
  <a
    :href="url"
    class="body"
    :class="{ isActiveLink }"
    target="_blank"
  >
    <img v-if="!isActiveImg" :src="Pin">
    <span>{{ address?.address }} </span>
    <img v-if="isActiveLink" :src="Link">
  </a>
</template>

<style scoped lang="scss">
  a {
  display: flex;
  gap: 8px;
  align-items: center;
  a {
    color: $color-base2;
  }

  img {
    width: clamp(22px, 5vw, $cover-28);
  }
}

@media screen and (max-width: 600px) {
  .isActiveLink {
    display: flex;
    padding: $cover-16 $cover-24;
    justify-content: space-between;
    align-items: center;
    border-radius: $cover-16;
    background: $color-opacity004;
  }
}
</style>
