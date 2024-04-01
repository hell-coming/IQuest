<script setup lang="ts">
import Close from '#/assets/svg/shared/close.svg?component'

interface Props {
  title?: string
  subTitle?: string
  customClass?: string
}

defineProps<Props>()

const model = defineModel<boolean>()
</script>

<template>
  <v-dialog v-model="model" :class="customClass" scrollable>
    <div class="modal-wrapper">
      <div class="modal-header">
        <div class="modal-header__title">
          <h2>{{ title }}</h2>
          <span class="footnote">{{ subTitle }}</span>
        </div>
        <Close class="pointer close" @click="model = false" />
        <slot name="header" />
      </div>
      <div class="modal-content">
        <slot name="content" />
      </div>
      <div class="modal-footer">
        <slot name="footer" />
      </div>
    </div>
  </v-dialog>
</template>

<style scoped lang="scss">
.modal {
  &-wrapper {
    max-height: calc(100vh - 40px);
    overflow: auto;
    background-color: $color-base1;
    padding: clamp($cover-16, 5vw, $cover-32);
    border-radius: $cover-12;
    width: 100%;
    max-width: 624px;
    display: flex;
    flex-direction: column;
    gap: $cover-40;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    @media screen and (max-width: 600px) {
      max-width: 100%;
      max-height: 100%;
      height: 100%;
    }
  }

  &-header {
    display: flex;
    justify-content: space-between;

    &__title {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
      max-width: 472px;
    }
  }

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-32;
  }

  &-footer {
    @media screen and (max-width: 600px) {
      margin-top: auto;
      margin-bottom: 20px;
    }
  }
}
</style>
