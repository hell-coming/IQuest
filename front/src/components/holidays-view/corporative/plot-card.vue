<script setup lang="ts">
import DescriptionModal from '../corporative/modal/description-modal.vue'
import Difficulty from '#/components/quest-view/quest/info/difficulty-chip.vue'
import Chip from '#/components/quest-view/quest/info/assist-chip.vue'
import type { PlotList } from '#/utils/mock/plot-list'
import Button from '#/components/shared/button.vue'

const props = defineProps<{ info: PlotList }>()

const chips = computed(() => {
  return [
    { title: `${props.info.chips[0].name}` },
    { title: `${props.info.chips[4].name}` },

    { title: `${props.info.chips[2].name}` },
    { title: `${props.info.chips[3].name}` },
    {
      title: `${props.info.chips[1].name}`,
      slot: {
        is: Difficulty,
        props: { max: props.info.chips[1].def },
      },
    },

  ]
})

const modal = ref(false)

function openModal() {
  modal.value = true
}
</script>

<template>
  <div class="plot">
    <div class="plot-img">
      <img v-lazy-src="`/plots/${info.img}.webp`" class="loading-lazy">
    </div>
    <div class="plot-main">
      <div class="plot-main__info">
        <h2>{{ info.name }}</h2>
        <div class="chips">
          <Chip v-for="item in chips" :key="item.title" :name="item.title">
            <component
              v-bind="item.slot?.props"
              :is="item.slot?.is"
            />
          </Chip>
        </div>
      </div>
      <div class="plot-main__description">
        <span class="body">Описание</span>
        <div class="plot-main__description-content">
          <p class="footnote">
            {{ info.description }}
          </p>
          <Button name="Читать полностью" :footnote="true" @click="openModal" />
        </div>
      </div>
    </div>
    <DescriptionModal v-model="modal" :description="info.description" :name="info.name" />
  </div>
</template>

<style scoped lang="scss">
.plot {
  display: flex;
  flex-direction: column;
  max-height: 672px;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  overflow: hidden;

  &-img {
    height: clamp(140px, 30vw, 404px);
    position: relative;
    overflow: hidden;

    &::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: linear-gradient(
        0deg,
        rgba(139, 65, 222, 0.4) 0%,
        rgba(139, 65, 222, 0.4) 100%
      );
      opacity: 0.85;
      z-index: 2;
    }

    img {
      width: 100%;
      object-fit: cover;
      object-position: center;
      height: 100%;
      position: relative;
      z-index: 1;
    }
  }

  &-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: clamp($cover-20, 3vw, $cover-40);
    flex-wrap: wrap;
    background-color: $color-opacity004;

    &__info {
      max-width: 572px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: clamp($cover-16, 3vw, $cover-32);

      .chips {
        display: flex;
        flex-wrap: wrap;
        gap: clamp($cover-12, 3vw, $cover-16);
        align-items: center;
        align-content: center;
      }

      @media screen and (max-width: 1360px) {
        max-width: 100%;
      }
    }

    &__description {
      max-width: 572px;
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: $cover-12;

      &-content {
        display: flex;
        flex-direction: column;
        gap: $cover-16;

        p {
          overflow: hidden;
          display: -webkit-box;
          -webkit-box-orient: vertical;
          -webkit-line-clamp: 3;
        }
      }

      @media screen and (max-width: 1360px) {
        max-width: 100%;
      }
    }

    @media screen and (max-width: 1360px) {
      gap: 24px;
    }
  }
}
</style>
