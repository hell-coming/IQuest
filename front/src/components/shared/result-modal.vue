<script setup lang="ts">
import Button from '#/components/shared/button.vue'
import CustomerSupport from '#/assets/svg/shared/customer-support.svg?url'
import Close from '#/assets/svg/shared/close.svg?component'
import type { ResultModal } from '#/types/shared/common'

defineProps<{ isSuccess: ResultModal }>()
const model = defineModel<boolean>()
</script>

<template>
  <v-dialog v-model="model" :scrollable="true">
    <div class="modal-wrapper">
      <template v-if="isSuccess.status === 'success'">
        <div class="modal-header">
          <div class="modal-header__title">
            <h2 class="success">
              Успешное
            </h2>
            <h2 class="success">
              {{ isSuccess.info.title }}
            </h2>
          </div>
          <span class="footnote">{{ isSuccess.info.subTitle }}</span>
        </div>
        <div class="modal-content">
          <img :src="CustomerSupport">
          <div class="modal-content__text">
            <span class="body">Оператор перезвонит вам для подтверждения заявки</span>
            <span class="footnote">Будьте на связи:)</span>
          </div>
        </div>
        <div class="modal-footer">
          <Button name="Закрыть" @click="$router.go(0)" />
        </div>
      </template>
      <template v-else>
        <div class="modal-header__error">
          <div class="modal-header__text">
            <h2 class="error">
              Ошибка:
            </h2>
            <h2 class="error">
              {{ isSuccess.info.title }}
            </h2>
          </div>
          <Close class="pointer close" @click="model = false" />
        </div>
        <div class="modal-content__error">
          <span class="footnote">Что то пошло не так...</span>
          <span class="body">Пожалуйста, перезагрузите страницу и попробуйте еще раз</span>
        </div>
        <div class="modal-footer">
          <Button
            :button-light="true"
            name="Перезагрузить страницу"
            @click="$router.go(0)"
          />
        </div>
      </template>
    </div>
  </v-dialog>
</template>

<style scoped lang="scss">
.success {
  color: $color-green;
}
.error {
  color: $color-red;
}
.modal {
  &-wrapper {
    overflow: auto;
    background-color: $color-base1;
    padding: $cover-32;
    border-radius: $cover-12;
    width: 100%;
    max-width: 624px;
    display: flex;
    flex-direction: column;
    gap: clamp($cover-32, 10vw, $cover-48);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    @media screen and (max-width: 600px) {
      border-radius: 0;
      padding: $cover-24 $cover-16;
    }
  }

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-8;

    &__error {
      display: flex;
      justify-content: space-between;
    }

    &__text {
      display: flex;
      flex-direction: column;
    }
  }

  &-content {
    display: flex;

    gap: $cover-16;

    img {
      width: clamp($cover-64, 15vw, 83px);
      height: clamp($cover-64, 15vw, 82px);
    }

    &__error {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
    }

    &__text {
      height: 100%;
      gap: $cover-8;
      display: flex;
      flex-direction: column;
    }
  }

  &-footer {
    display: flex;
    gap: 24px;
  }
}
</style>
