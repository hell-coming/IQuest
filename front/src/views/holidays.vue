<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import Cover from '#/components/holidays-view/cover.vue'
import PackagesMain from '#/components/holidays-view/packages/packege-container.vue'
import PackagesCorp from '#/components/holidays-view/packages/package-corp.vue'

const route = useRoute()
const stores = setupStore(['holiday', 'global'])
const corp = ref(false)

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized || isViewLoading.value
})

async function loadView() {
  isViewLoading.value = true
  stores.holiday.$reset()
  await stores.holiday.fetchHoliday(`${route.params.id}`)

  if (route.params.id === '3')
    corp.value = true
  else
    corp.value = false

  isViewLoading.value = false
}

watch(() => route.params.id, loadView)

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section v-if="stores.holiday.holiday">
      <Cover :type="stores.holiday.holiday.type" :corp-info="corp" />
      <section v-if="!corp">
        <PackagesMain :key="stores.holiday.getFirstPackegs?.id" />
      </section>
      <section v-else class="wrapper">
        <PackagesCorp />
      </section>
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.wrapper {
  display: flex;
  flex-direction: column;
  gap: clamp($cover-64, 20vw, 108px);
}
</style>
