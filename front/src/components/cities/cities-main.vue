<script setup lang="ts">
import DropList from './cities-list.vue'
import CityModal from './city-modal.vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'
import Pin from '#/assets/svg/burger/pin.svg?url'

const stores = setupStore(['city'])

const cityDialog = ref(false)

function openCityModal() {
  cityDialog.value = true
}

watch(() => stores.city.selectedCity, () => {
  cityDialog.value = false
})

const list = ref(false)

function close() {
  list.value = false
}
</script>

<template>
  <div
    v-click-outside="close"
    v-scroll="close"
    class="link footnote city pointer"
    :class="{ active: list }"
    @click="list = !list"
  >
    <span>[</span>
    {{ stores.city.selectedCity.name }}
    <Arrow class="arrow" />
    <Transition name="holidays-list">
      <DropList v-show="list" class="drop-down" :item="stores.city.cities!" />
    </Transition>

    <span>]</span>
  </div>
  <div class="city-mobile" @click="openCityModal">
    <img :src="Pin">
    <span class="body">{{ stores.city.selectedCity.name }}</span>
  </div>
  <CityModal v-model="cityDialog" />
</template>

<style scoped lang="scss">
.city {
  padding: 8px 0;
  display: flex;
  gap: $cover-4;
  position: relative;
  z-index: 10;

  &-mobile {
    display: none;
  }

  span {
    visibility: hidden;
  }
  .drop-down {
    top: 40px;
    position: absolute;
    z-index: 10;
  }
  .arrow {
    transition: all 0.1s ease-in-out;
    transform: rotate(0);

    :deep(path) {
      stroke-opacity: 0.6;
    }
  }

  &:hover {
    span {
      visibility: visible;
    }
    .drop-down {
      display: block;
    }
  }

  @media screen and (max-width: 1024px) {
    display: none;
  }

  &-mobile {
    display: none;
    gap: 2px;
    align-items: center;
    opacity: 0.6;

    img {
      width: 22px;
    }

    @media screen and (max-width: 1024px) {
      display: flex;
    }
  }
}

.active {
  color: $color-base2;
  .arrow {
    transform: rotate(180deg);
    :deep(path) {
      stroke-opacity: 1;
    }
  }
  span {
    visibility: visible;
    color: $color-base2;
  }
  .drop-down {
    display: block;
  }
}
</style>
