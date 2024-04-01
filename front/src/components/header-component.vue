<script setup lang="ts">
import { LottieAnimation } from 'lottie-web-vue'
import { useRoute } from 'vue-router'
import { EAppRoutePaths } from '../types/routes'
import DropList from './shared/drop-list.vue'
import City from '#/components/cities/cities-main.vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg'
import Logo from '#/assets/svg/logo/logo.svg?component'
import LogoMobile from '#/assets/svg/logo/logo-mobile.svg?component'
import BurgerOpen from '#/assets/animation/burger-open.json'
import BurgerClose from '#/assets/animation/burger-close.json'

const stores = setupStore(['holidaysList', 'city', 'global'])

const links = [
  { name: 'Квесты', link: EAppRoutePaths.Home },
  { name: 'Праздники', link: '' },
  { name: 'Сертификат', link: EAppRoutePaths.Certificat },
  { name: 'Контакты', link: EAppRoutePaths.Contacts },
]

const isMenuOpened = ref(false)
const isMenuHoliday = ref(false)

const lottie = ref()
const lottieRefresh = ref(new Date())
const lockMenu = ref(false)

function toggleMenu() {
  if (lockMenu.value)
    return

  lockMenu.value = true
  isMenuOpened.value = !isMenuOpened.value
  isMenuHoliday.value = false
  lottie.value.play()
  setTimeout(() => {
    defaultPosition()
  }, 500)
}

function openMenuHoliday(index: number) {
  if (index === 1)
    isMenuHoliday.value = !isMenuHoliday.value
  else
    isMenuOpened.value = false
}

function getFirstWord(text: string) {
  const words = text.split(' ')
  return words[0]
}

function closeMenu() {
  isMenuOpened.value = false
  isMenuHoliday.value = false
}

watch(() => stores.city.selectedCity, () => {
  defaultPosition()
})

const route = useRoute()

watch(() => route.path, () => {
  defaultPosition()
})

function defaultPosition() {
  lottieRefresh.value = new Date()
  lockMenu.value = false
}

const list = ref(false)

function handleMouseOver(index: number) {
  if (index === 1)
    list.value = !list.value
  else
    list.value = false
}

function close() {
  list.value = false
}
</script>

<template>
  <header class="container-header">
    <div class="header">
      <router-link to="/">
        <Logo />
      </router-link>
      <div
        v-click-outside="close"
        v-scroll="close"
        class="header-links"
      >
        <template v-for="(link, index) in links">
          <router-link
            v-if="stores.holidaysList.holidaysList.length || index !== 1"
            :key="link.name"
            :class="{ active: list && index === 1 }"
            :to="link.link"
            class="footnote"
            @click="handleMouseOver(index)"
          >
            <div
              class="link" :class="{
                selected: $route.path === link.link,
                holiday: index === 1,
              }"
            >
              <span>[</span>
              {{ link.name }}
              <div v-if="index === 1" class="select">
                <Arrow class="arrow" />
                <Transition name="holidays-list">
                  <DropList v-show="list" class="drop-down" :item="stores.holidaysList.holidaysList" />
                </Transition>
              </div>
              <span>]</span>
            </div>
          </router-link>
        </template>
      </div>
      <City />
    </div>
    <div class="header-mobile">
      <router-link class="logo" to="/">
        <LogoMobile />
      </router-link>
      <div class="burger-menu">
        <LottieAnimation
          :key="+lottieRefresh"
          ref="lottie"
          :animation-data="isMenuOpened ? BurgerClose : BurgerOpen"
          :loop="false"
          :auto-play="false"
          :speed="1"
          @click="toggleMenu"
        />
      </div>
      <Transition name="menu">
        <div v-if="isMenuOpened" v-click-outside="toggleMenu" class="burger-menu__drop">
          <div class="burger-menu__drop-list">
            <div
              v-for="link, index in links" :key="link.name" class="burger-menu__drop-links"
              :class="{ 'holiday-burger': index === 1 }"
            >
              <router-link
                v-if="stores.holidaysList.holidaysList.length || index !== 1"
                class="h3" :class="{
                  'selected': $route.path === link.link,
                  'holiday': index === 1,
                  'holiday-active': isMenuHoliday && index === 1,
                }" :to="link.link" @click="openMenuHoliday(index)"
              >
                {{ link.name }}
                <Arrow v-if="index === 1" class="arrow-burger" :class="{ 'arrow-active': isMenuHoliday }" />
              </router-link>
              <Transition name="holiday">
                <template v-if="isMenuHoliday && index === 1">
                  <div class="holiday-gup">
                    <div class="holiday-list">
                      <router-link
                        v-for="holiday in stores.holidaysList.holidaysList" :key="holiday.id" class="h3"
                        :to="`/holidays/${holiday.id}`" @click="closeMenu"
                      >
                        {{ getFirstWord(holiday.type) }}
                      </router-link>
                    </div>
                    <svg width="2" height="120" viewBox="0 0 2 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 1L1.00001 119" stroke="white" stroke-opacity="0.6" stroke-width="0.5" stroke-linecap="round" />
                    </svg>
                  </div>
                </template>
              </Transition>
            </div>
          </div>
          <div class="burger-menu__city">
            <City />
          </div>
        </div>
      </Transition>
    </div>
  </header>
</template>

<style scoped lang="scss">
.header {
  z-index: 2;
  position: absolute;
  max-width: 1440px;
  display: flex;
  padding: 20px clamp(16px, 5vw, 88px);
  width: 100%;
  max-height: 80px;
  justify-content: space-between;
  align-items: center;

  &-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;

    a {
      color: $color-opacity06;
      display: flex;
      gap: 8px;
    }
  }

  &-select {
    color: $color-opacity06;
    cursor: pointer;
  }

  &-mobile {
    display: none;
    position: relative;

    .burger-menu {
      display: flex;
      width: 56px;
      height: 60px;

      :deep(html) {
        overflow: hidden !important;
      }

      &__drop {
        right: 0;
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 57px;
        padding-bottom: 16px;
        justify-content: space-between;
        background-color: $color-base1;
        width: 100%;
        align-items: flex-end;
        border-bottom: 1px solid $color-opacity025;
        height: 488px;
        z-index: 12;

        &-list {
          padding-top: 10px;
        }

        &-links {
          display: flex;
          padding: 12px 16px;
          justify-content: flex-end;
          align-items: center;

          gap: 4px;

          a {
            color: $color-opacity06;
          }
        }

        .holiday-list {
          width: 100;
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          padding: 0 $cover-8;

          a {
            padding: $cover-12;

            &:nth-child(1) {
              padding-top: 28px;
            }
          }
        }
      }

      &__city {
        margin-right: $cover-16;
        display: flex;
        padding: $cover-12 $cover-24;
        border-radius: $cover-12;
        background: $color-opacity004;
      }
    }
  }

  @media screen and (max-width: 1024px) {
    display: none;

    &-mobile {
      display: flex;
      padding-top: 14px;
      padding-bottom: 14px;
      padding-left: clamp(16px, 5vw, 88px);
      width: 100%;
      max-height: 60px;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid $color-opacity025;
    }
  }
}

.selected {
  position: relative;
  color: $color-base2 !important;

  span {
    visibility: visible !important;
  }

  path {
    stroke: $color-base2;
  }
}

.link {
  display: flex;
  padding: 8px 0;
  justify-content: center;
  align-items: center;
  gap: 4px;

  span {
    visibility: hidden;
  }

  &:hover span {
    visibility: visible;
  }

  .select {
    display: flex;
  }
}

.holiday {
  display: flex;
  align-items: center;
  position: relative;
  gap: $cover-4;

  &-gup {
    display: flex;
    align-items: center;

    svg {
      padding-top: 10px;
    }
  }

  .drop-down {
    top: 40px;
    right: -10px;
    position: absolute;
    z-index: 20;
  }

  &-active {
    color: $color-base2 !important;
  }

  .arrow {
    transition: transform 0.1s ease-in-out;

    :deep(path) {
      stroke-opacity: 0.6;
    }

    transform: rotate(0);

    &-burger {
      transition: transform 0.1s ease-in-out;
      transform: rotate(0);

      :deep(path) {
        stroke-opacity: 0.6;
      }
    }

    &-active {
      transform: rotate(180deg);
      :deep(path) {
        stroke-opacity: 1;
      }
    }
  }

  &-burger {
    flex-direction: column;
    justify-content: flex-end;
    width: 100%;
    align-items: flex-end !important;
  }
}

.active {
  .link {
    color: $color-base2;
  }

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
