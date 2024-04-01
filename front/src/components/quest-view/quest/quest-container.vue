<script setup lang="ts">
import QuestInfo from './info/quest-info.vue'
import QuestImages from './quest-images.vue'
import QuestDescription from './quest-description.vue'
import type { Quest } from '#/types/models/quest'
import Back from '#/components/shared/back.vue'

defineProps<{
  quest: Quest
}>()
</script>

<template>
  <section class="container">
    <Back />
    <div class="main-container">
      <QuestImages class="img-main" :images="quest.images" />
      <QuestDescription class="description-main" :description="quest.description" />
      <QuestInfo class="info-main" :info="quest" />
    </div>
  </section>
</template>

<style scoped lang="scss">
.container {
  display: flex;
  flex-direction: column;
  gap: $cover-16;
  width: 100%;
}

.main-container {
  height: max-content;
  display: grid;
  justify-content: space-between;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(1, 1fr);
  gap: clamp($cover-24, 4vw, $cover-32);

  .info-main {
    grid-column: 2;
    grid-row: 1;
    gap: 35px;
  }

  .img-main {
    grid-column: 1;
    grid-row: 1;
  }

  @media screen and (max-width: 870px) {
    grid-template-columns: 1fr;
    grid-template-rows: repeat(1, 1fr);

    .img-main {
      grid-column: 1;
      grid-row: 1;
      max-width: 100%;
    }
    .info-main {
      max-width: 100%;
      gap: $cover-24;
      height: auto;
      position: static;
      grid-column: 1;
      grid-row: 2;
    }
  }
}
</style>
