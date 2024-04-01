<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import QuestContainer from '#/components/quest-view/quest/quest-container.vue'
import QuestBooking from '#/components/quest-view/booking/booking.vue'
import AddServices from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'

const route = useRoute()

const stores = setupStore(['quest', 'services', 'global', 'questList', 'city'])

stores.quest.$reset()

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized || isViewLoading.value
})

const { questBookingEl } = storeToRefs(stores.quest)

watch(() => route.params.id, loadView)
watch(() => stores.city.selectedCity, loadView)

async function loadView() {
  isViewLoading.value = true
  await Promise.allSettled([
    stores.quest.fetchQuest(`${route.params.id}`),
    stores.services.fetchServices(),
    stores.questList.fetchQuests(),
  ])
  isViewLoading.value = false
}

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="quest">
      <QuestContainer :quest="stores.quest.quest!" />
      <QuestBooking ref="questBookingEl" :id-quest="stores.quest.quest!.id" />
      <AddServices />
      <QuestCardGrid />
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.quest {
  padding-top: clamp(40px, 10vw, 120px);
  display: flex;
  flex-direction: column;
  gap: clamp(64px, 10vw, 108px);

  section:last-child {
    margin-bottom: 108px;
  }
}
</style>
