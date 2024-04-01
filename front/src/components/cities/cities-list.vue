<script setup lang="ts">
import type { City } from '#/types/models/city'

defineProps<{ item?: City[] }>()

const stores = setupStore('city')
</script>

<template>
  <div class="dorp-list pointer">
    <span
      v-for="element in item"
      :key="element.id"
      class="footnote"
      @click="stores.selectCity(element)"
    >
      {{ element.name }}
    </span>
  </div>
</template>

<style scoped lang="scss">
.dorp-list {
  display: flex;
  padding: $cover-16;
  flex-direction: column;
  border-radius: $cover-12;
  background-color: $color-base1;
  border: 1px solid $color-opacity012;

  span {
    display: flex;
    padding: $cover-12;
    align-items: center;
    transition: all 0.2s ease-out;
    &:hover {
      color: $color-base2;
    }
  }
}
</style>
