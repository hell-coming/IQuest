<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import ContactsMain from '#/components/contacts/contacts-main.vue'

const stores = setupStore(['filialList', 'city', 'global'])

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized || isViewLoading.value
})

async function loadView() {
  isViewLoading.value = true

  await stores.filialList.fetchFilial()
  isViewLoading.value = false
}

watch(() => stores.city.selectedCity, () => {
  loadView()
})

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="container">
      <ContactsMain />
    </section>
  </ViewWrapper>
</template>

<style scoped>
.container {
  margin-top: clamp(40px, 10vw, 160px);
}
</style>
