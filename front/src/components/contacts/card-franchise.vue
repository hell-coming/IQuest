<script setup lang="ts">
interface Props {
  img: string
  title: string
  email?: boolean
}

defineProps<Props>()

const store = setupStore('contact')
</script>

<template>
  <div class="card" :class="{ email }">
    <img class="card-img" :src="`/icons/franchise/${img}.svg`" alt="img">
    <span class="footnote">
      {{ title }}
      <template v-if="email">
        <span class="active">
          {{ store.getEmail }}
        </span>
      </template>
    </span>
  </div>
</template>

<style scoped lang="scss">
.card {
  width: 100%;
  max-width: 400px;
  max-height: 293px;
  gap: clamp($cover-12, 2vw, $cover-16);
  height: 100%;
  display: flex;
  padding: $cover-32;
  flex-direction: column;
  border-radius: 8px;

  border: 1px solid $color-opacity012;

  &-img {
    max-width: clamp(60px, 5vw, 80px);
    max-height: clamp(60px, 5vw, 80px);

    img {
      width: 100%;
      height: 100%;
    }
  }

  @media screen and (max-width: 600px) {
    padding: $cover-24 $cover-20;
    max-width: 100%;
    height: auto;
  }
}
.active {
  color: $color-base2;
}
.email {
  border: none;
  background: $color-opacity004;
}
</style>
