<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import AddServicesVue from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'
import BanerSwiper from '#/components/stocks-swiper/baner-swiper.vue'
import BanerSwiperMob from '#/components/stocks-swiper/baner-swiper-mob.vue'

const stores = setupStore(['stocks', 'contact', 'services', 'city', 'global', 'questList', 'filialList'])

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => (
  !stores.global.isInitialized
  || isViewLoading.value),
)

async function loadView() {
  isViewLoading.value = true

  await Promise.allSettled([
    stores.questList.fetchQuests(),
    stores.contact.fetchContact(),
    stores.stocks.fetchStocks(),
    stores.filialList.fetchFilial(),
  ])
  isViewLoading.value = false
}

watch(() => stores.city.selectedCity, loadView)

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="bag-black">
      <BanerSwiper class="baner-pc" />
      <BanerSwiperMob class="baner-mob" />
      <QuestCardGrid />
      <AddServicesVue />
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.bag-black {
  display: flex;
  flex-direction: column;
  gap: clamp($cover-64, 10vw, 108px);
}

@media screen and (max-width: 1024px) {
  .baner-pc {
    display: none;
  }
  .baner-mob {
    display: flex;
  }
  .bag-black {
    margin-top: 40px;
  }
}
</style>
