<script setup lang="ts">
export interface Props {
  icon: string
  description: string
  footnote?: boolean
}

defineProps<{ item: Props }>()
</script>

<template>
  <div class="item">
    <div class="item-img">
      <img :src="`/icons/details/${item.icon}.svg`">
    </div>
    <p :class="{ footnote: item.footnote, smallFootnote: !item.footnote }">
      {{ item.description }}
    </p>
  </div>
</template>

<style scoped lang="scss">
.item {
  display: flex;
  height: 100%;
  width: 100%;
  padding: $cover-32;
  flex-direction: column;
  align-items: flex-start;
  gap: $cover-10;
  border-radius: $cover-8;
  border: 1px solid $color-opacity012;

  @media screen and (max-width: 600px) {
    padding: 24px 20px;
    height: auto;
  }

  &-img {
    max-width: clamp(60px, 5vw, 80px);
    max-height: clamp(60px, 5vw, 80px);

    img {
      width: 100%;
      height: 100%;
    }
  }
}
</style>
