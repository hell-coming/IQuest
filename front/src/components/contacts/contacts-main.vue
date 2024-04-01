<script setup lang="ts">
import Email from '../shared/email.vue'
import Map from './map.vue'
import Social from './social.vue'
import CardFranchise from './card-franchise.vue'
import PhoneNumber from '#/components/shared/phone-number.vue'

const store = setupStore(['contact', 'filialList'])

const framchise = [
  { title: `Наша компания — лидер рынка реалити-квестов в Томске`, img: 'people' },
  { title: `Мы открыты к сотрудничеству и предлагаем помощь и поддержку на всех этапах вашего проекта`, img: 'rishake' },
  { title: `Чтобы связаться, отправьте письмо с информацией о себе, планах и месте создания квестов на `, img: 'mail', email: true },
]
</script>

<template>
  <div class="block">
    <div class="block-header">
      <div v-if="store.contact.getEmail || store.contact.getPhone" class="block-header__contacts">
        <h2>Контакты</h2>
        <div class="contacts-list">
          <PhoneNumber v-if="store.contact.getPhone" class="contacts-list__item" />
          <Email v-if="store.contact.getEmail" class="contacts-list__item" />
        </div>
      </div>
      <div v-if="store.contact.getSocial.length" class="block-header__contacts">
        <h2>Соц сети</h2>
        <div>
          <Social />
        </div>
      </div>
    </div>
    <Map />
    <div class="block-footer">
      <h2>
        открытие квеструмов
        <span class="gradient">по франшизе</span>
      </h2>
      <div class="block-footer__container">
        <CardFranchise v-for="item in framchise" :key="item.img" :="item" />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.gradient {
  background: $color-gradient;
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.block {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: clamp($cover-64, 10vw, 108px);

  &-header {
    display: grid;
    width: 100%;
    grid-template-columns: 1fr 1fr;
    gap: $cover-24;

    @media screen and (max-width: 1024px) {
      gap: $cover-40;

      grid-template-columns: 1fr;
    }

    &__contacts {
      display: flex;
      flex-wrap: wrap;
      flex-direction: column;
      gap: $cover-24;
      width: 100%;

      .contacts-list {
        display: flex;
        gap: clamp($cover-16, 3vw, $cover-32);
        flex-wrap: wrap;

        &__item {
          opacity: 0.6;
          transition: $hover-animation;
          &:hover {
            opacity: 1;
          }
        }
      }
    }
  }

  &-footer {
    display: flex;
    flex-direction: column;
    gap: $cover-40;

    &__container {
      align-items: flex-start;
      justify-content: center;
      flex-wrap: wrap;
      height: 100%;
      display: grid;
      gap: $cover-32;
      grid-template-columns: repeat(3, 1fr);

      @media screen and (max-width: 1024px) {
        grid-template-columns: repeat(2, 1fr);
      }

      @media screen and (max-width: 600px) {
        grid-template-columns: 1fr;
        gap: $cover-16;
      }
    }
    @media screen and (max-width: 600px) {
      gap: $cover-20;
    }
  }

  @media screen and (max-width: 375px) {
    h2 {
      letter-spacing: 0;
    }
  }
}
</style>
