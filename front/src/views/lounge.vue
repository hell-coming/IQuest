<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import Lounge from '#/components/lounge/lounge-main.vue'

const stores = setupStore(['filialList', 'global'])

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized || isViewLoading.value
})

async function loadView() {
  isViewLoading.value = true
  await Promise.allSettled([
    stores.filialList.fetchFilial(),
  ])
  isViewLoading.value = false
}

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="container">
      <Lounge />
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.container {
  margin-top: clamp(40px, 10vw, 112px);
}
</style>
