<script setup lang="ts">
import {
  YandexMap,
  YandexMapControlButton,
  YandexMapControls,
  YandexMapDefaultFeaturesLayer,
  YandexMapDefaultSchemeLayer,
  YandexMapMarker,
  YandexMapZoomControl,
} from 'vue-yandex-maps'
import type { LngLat } from '@yandex/ymaps3-types'
import { useRouter } from 'vue-router'
import Marker from '#/assets/svg/map/marker.svg?url'

const store = setupStore('filialList')

const active = ref(store.getFirstFilial.id)

const center = ref([store.getFirstFilial.longitude, store.getFirstFilial.latitude] as LngLat)

function mapToMove(lon: number, lat: number, id: number) {
  center.value = [lon, lat] as LngLat
  active.value = id
}

function openYandexMaps() {
  const address = store.filialList.find(item => item.id === active.value)
  const url = `https://yandex.ru/maps/?&ll=${address?.longitude},${address?.latitude}&text=${encodeURIComponent('iQuest')}&z=16`
  window.open(url, '_blank')
}
</script>

<template>
  <div class="map">
    <div class="map-button">
      <span
        v-for="item in store.filialList"
        :key="item.id"
        class="bodyBold pointer"
        :class="{ active: active === item.id }"
        @click="mapToMove(item.longitude, item.latitude, item.id)"
      >
        {{ item.address }}
      </span>
    </div>

    <div class="map-container">
      <YandexMap
        :settings="{
          location: {
            center,
            zoom: 12,
          },
          zoomRange: {
            min: 12,
            max: 20,
          },
        }"
        theme
        height="100%"
        width="100%"
      >
        <YandexMapDefaultSchemeLayer :settings="{ theme: 'dark' }" />
        <YandexMapDefaultFeaturesLayer />
        <YandexMapControls :settings="{ position: 'right' }">
          <YandexMapZoomControl />
        </YandexMapControls>
        <YandexMapControls :settings="{ position: 'bottom left' }">
          <YandexMapControlButton>
            <div class="open-maps-button" @click="openYandexMaps">
              Открыть Яндекс Карты
            </div>
          </YandexMapControlButton>
        </YandexMapControls>
        <YandexMapMarker
          v-for="marker in store.filialList"
          :key="marker.id"
          :settings="{
            coordinates: [marker.longitude, marker.latitude],
          }"
          position="top left-center"
        >
          <img class="pin" :src="Marker">
        </YandexMapMarker>
      </YandexMap>
    </div>
  </div>
</template>

<style scoped lang="scss">
.pin {
  display: block;
  margin: auto;
}

.open-maps-button {
  align-items: center;
  display: flex;
  font-size: 12px;
  justify-content: center;

  &::before {
    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj48cGF0aCBkPSJNMTIgMWE5LjAwMiA5LjAwMiAwIDAgMC02LjM2NiAxNS4zNjJjMS42MyAxLjYzIDUuNDY2IDMuOTg4IDUuNjkzIDYuNDY1LjAzNC4zNy4zMDMuNjczLjY3My42NzMuMzcgMCAuNjQtLjMwMy42NzMtLjY3My4yMjctMi40NzcgNC4wNi00LjgzMSA1LjY4OS02LjQ2QTkuMDAyIDkuMDAyIDAgMCAwIDEyIDF6bTAgMTIuMDc5YTMuMDc5IDMuMDc5IDAgMSAxIDAtNi4xNTggMy4wNzkgMy4wNzkgMCAwIDEgMCA2LjE1OHoiIGZpbGw9IiNGNDMiLz48L3N2Zz4=);
    background-size: 14px 14px;
    content: '';
    display: inline-block;
    height: 14px;
    margin-right: 6px;
    width: 14px;
  }
}

.bodyBold {
  color: $color-opacity06;
}
.map {
  display: flex;
  flex-direction: column;
  gap: clamp($cover-24, 5vw, $cover-32);

  &-button {
    display: flex;
    gap: clamp(17px, 5vw, $cover-32);
    flex-wrap: wrap;
  }

  &-container {
    border-radius: $cover-12;
    overflow: hidden;
    width: 100%;
    height: clamp(222px, 30vw, 492px);
  }
}

.active {
  color: $color-base2;
}
</style>
