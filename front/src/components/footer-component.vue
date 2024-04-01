<script setup lang="ts">
import type { Contact } from '../types/models/contact'
import Email from './shared/email.vue'
import PhoneNumber from './shared/phone-number.vue'
import AsapLogo from '#/assets/svg/logo/asapLogo.svg?url'
import LogoFull from '#/assets/svg/logo/logo_full.svg?url'

const store = setupStore('contact')

const link = ref([] as Contact[])

const linksSocial = reactive({
  vk: {
    link: '',
    img: 'vk.svg',
  },
  telegram: {
    link: '',
    img: 'telegram.svg',
  },
  youtube: {
    link: '',
    img: 'youtube.svg',
  },
  instagram: {
    link: '',
    img: 'insta.svg',
  },
})

watch(() => store.getSocial, () => {
  link.value = store.getSocial
  updateLinks()
}, { immediate: true })

function updateLinks() {
  linksSocial.vk.link = link.value?.find(item => item.type.name === 'VK')?.value || ''
  linksSocial.telegram.link = link.value?.find(item => item.type.name === 'Telegram')?.value || ''
  linksSocial.youtube.link = link.value?.find(item => item.type.name === 'YouTube')?.value || ''
  linksSocial.instagram.link = link.value?.find(item => item.type.name === 'Instagram')?.value || ''
}

const linkASAP = 'https://asapeducation.ru/?utm_course=iquest_site'
</script>

<template>
  <footer class="border">
    <div class="container footer">
      <img :src="LogoFull" class="logo">
      <div class="footer-links">
        <div class="footer-links__contacts">
          <PhoneNumber />
          <Email />
        </div>
        <div class="footer-links__social">
          <template
            v-for="link in linksSocial"
            :key="link.img"
          >
            <a
              v-if="link.link"
              target="_blank"
              :href="link.link"
            >
              <img :src="`/icons/social/${link.img}`">
            </a>
          </template>
        </div>
      </div>
      <div class="footer-privacy">
        <a href="/privacy-policy.pdf" target="_blank" class="smallFootnote privecy">
          Политика конфиденциальности
        </a>
        <span class="smallFootnote">
          Разработано в
          <a :href="linkASAP" target="_blank">
            <img :src="AsapLogo">
          </a>
        </span>
      </div>
    </div>
  </footer>
</template>

<style scoped lang="scss">
.border {
  border-top: 1px solid $color-opacity025 !important;
  background-image: url('/gradient/footer-gradient.svg');
  background-repeat: no-repeat;
  background-position: center top;
  margin-top: clamp(64px, 10vw, 108px);

  @media screen and (max-width: 1024px) {
    background-position: center 160px;
  }
}

.footer {
  height: 100%;
  margin-inline: auto;
  padding: clamp(32px, 3vw, 72px) clamp(16px, 3vw, 88px);
  justify-content: space-between;
  max-height: 282px;

  &-links {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &__contacts {
      display: flex;
      flex-direction: column;
      gap: 12px;

      span {
        display: flex;
        gap: 8px;
      }
    }

    &__social {
      display: flex;
      gap: 16px;
      align-items: flex-start;

      a {
        display: flex;
        align-items: center;

        img {
          opacity: 0.6;
          transition: $hover-animation;
        }

        &:hover {
          img {
            opacity: 1;
          }
        }
      }
    }
  }

  &-privacy {
    gap: 30px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;

    a {
      color: $color-base2;
    }

    span {
      color: #f0f0f0;
      display: flex;
      align-items: center;
      gap: 8px;
    }
  }

  @media screen and (max-width: 1024px) {
    display: grid;
    grid-template-columns: 1fr;
    gap: 41px;
    max-height: 100%;

    &-links {
      grid-column: 1;
      grid-row: 1;
      align-items: center;
      gap: 41px;
      flex-direction: column-reverse;

      &__social {
        img {
          width: 100%;
          height: 32px;
        }
      }

      &__contacts {
        .body {
          margin: 0 auto;
        }
      }
    }

    &-privacy {
      grid-column: 1;
      grid-row: 3;
      align-items: center;
      gap: $cover-12;

      a {
        width: 80px;
        height: 40px;

        img {
          width: 100%;
        }
      }

      .privecy {
        width: max-content;
      }
    }

    .logo {
      max-width: 88px;
      width: 100%;
      padding-left: 18.5px;
      margin: 0 auto;
    }
  }
}
</style>
