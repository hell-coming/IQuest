<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import CertificateMain from '#/components/сertificate/сertificate-main.vue'

const stores = setupStore(['сertificateList', 'global'])

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized || isViewLoading.value
})

async function loadView() {
  isViewLoading.value = true
  await Promise.allSettled([
    stores.сertificateList.fetchCertificates(),
  ])
  isViewLoading.value = false
}

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="container">
      <CertificateMain />
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.container {
  margin-top: clamp(40px, 10vw, 144px);
  height: 100%;
}
</style>
