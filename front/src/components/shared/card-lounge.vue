<script setup lang="ts">
import { EAppRouteNames } from '#/types/routes'

const loundge = {
  name: 'Лаунж зона',
  img: 'loundge',
  tag: '600р/30 мин • 1000р/1 час',
}

const store = setupStore(['filialList'])

const isLoundge: any = computed(() => {
  if (store.filialList.filialList.find(item => item.lounges.length > 0))
    return isLoundge.value = EAppRouteNames.Lounge
})
</script>

<template>
  <router-link :to="{ name: isLoundge }" class="hover-container" :class="{ 'no-pointer': !isLoundge }">
    <div class="card">
      <div class="card-image">
        <img v-lazy-src="`/loundge/${loundge.img}.webp`" class="loading-lazy">
      </div>
      <div class="card-body">
        <span class="bodyBold">{{ loundge.name }}</span>
        <div class="tag">
          <span class="smallFootnote">{{ loundge.tag }}</span>
        </div>
      </div>
    </div>
  </router-link>
</template>

<style scoped lang="scss">
.card {
  width: 400px;
  max-height: 400px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;

  border-radius: $cover-8;
  border: 1px solid $color-opacity004;

  &-image {
    width: 100%;
    height: 246px;
    overflow: hidden;
  }

  img {
    height: 100%;
    width: 100%;
    object-fit: cover;
  }

  &-body {
    height: 100%;
    max-height: clamp(122px, 20vw, 152px);
    background: $color-opacity004;
    padding: clamp($cover-20, 3vw, $cover-24);
    display: flex;
    flex-direction: column;
    gap: clamp($cover-28, 3vw, $cover-36);
  }

  @media screen and (max-width: 1024px) {
    width: 100%;
  }
}

.tag {
  width: max-content;
  display: flex;
  padding: $cover-8 $cover-12;
  gap: $cover-8;
  align-items: center;
  border-radius: 120px;
  border: 1px solid $color-opacity004;
  background: transparent;
}

.hover-container {
  display: flex;

  @media screen and (max-width: 1024px) {
    width: 100%;
  }
}
</style>
