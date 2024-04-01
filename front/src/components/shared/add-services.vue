<script setup lang="ts">
import PhoneNumber from '#/components/shared/phone-number.vue'
import CardLoundge from '#/components/shared/card-lounge.vue'

const stores = setupStore('services')

stores.fetchServices()
</script>

<template>
  <section class="add-services container">
    <div class="add-services__body">
      <h2>Доп услуги</h2>
      <div class="add-services__info">
        <div class="add-services__info-header d-flex">
          <PhoneNumber />
          <span class="footnote">подробности у нашего оператора</span>
        </div>
        <div class="add-services__info-list">
          <div
            v-for="item in stores.services"
            :key="item.name"
            class="add-services__info-item"
          >
            <span class="body">{{ item.name }}</span>
            <span class="footnote">
              {{ item.price }}₽/{{ item.unit }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <CardLoundge />
  </section>
</template>

<style scoped lang="scss">
.add-services {
  max-width: 1264px;
  width: 100%;
  display: inline-flex;
  padding: $cover-40;
  justify-content: space-between;
  gap: clamp(50px, 7vw, 102px);

  border-radius: $cover-12;
  border: 2px solid $color-opacity012;

  &__body {
    display: flex;
    flex-direction: column;

    width: 100%;
    gap: $cover-32;
    max-width: 722px;

    @media screen and (max-width: 1024px) {
      max-width: 100%;
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    gap: $cover-24;

    &-header {
      gap: $cover-12;
      align-items: center;
      flex-wrap: wrap;

      span {
        display: flex;

        &:first-child {
          gap: $cover-8;
        }
      }
    }

    &-list {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }

    &-item {
      display: flex;
      width: 100%;
      justify-content: space-between;
      padding-bottom: 4px;
      border-bottom: 1px solid $color-opacity025;

      .footnote {
        text-align: right;
      }
    }
  }

  @media screen and (max-width: 1280px) {
    max-width: 100%;
    border: none;
    border-radius: 0%;
    border-top: 1px solid $color-opacity025;
    border-bottom: 1px solid $color-opacity025;
  }

  @media screen and (max-width: 1024px) {
    padding: $cover-24 $cover-16;
    flex-wrap: wrap;
  }
}
</style>
