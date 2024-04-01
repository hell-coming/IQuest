<script setup lang="ts">
import { useRouter } from 'vue-router'
import { EAppRouteNames } from '../types/routes'
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import Error from '#/assets/svg/error/error.svg?url'
import Button from '#/components/shared/button.vue'

const router = useRouter()
const stores = setupStore(['global'])

const isLoading = computed(() => {
  return !stores.global.isInitialized
})

function goToQuest() {
  router.push({ name: EAppRouteNames.Home })
}

function goBack() {
  router.go(-1)
}
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <div class="error">
      <div class="error-header">
        <img :src="Error" alt="">
        <h3>Страница не найдена</h3>
      </div>
      <div class="error-content">
        <Button :button-light="true" name="Смотреть квесты" @click="goToQuest" />
        <Button :button-light="false" name="Назад" @click="goBack" />
      </div>
    </div>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.error {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  gap: $cover-48;

  &-header {
    align-items: center;
    display: flex;
    flex-direction: column;
    gap: $cover-16;

    img {
      overflow: visible;
      padding-left: 72px;
      max-width: clamp(260px, 40vw, 330px);
    }
  }

  &-content {
    display: flex;
    gap: $cover-24;
    width: 566px;

    @media (max-width: 600px) {
      position: absolute;
      bottom: 0;
      flex-wrap: wrap;
      width: 90%;
      gap: $cover-16;
      :deep(.button) {
        border-radius: $cover-12;
      }
    }
  }

  @media (max-width: 600px) {
    min-height: 80vh;
  }
}
</style>
