<script setup lang="ts">
import { vMaska } from 'maska'
import type { Lounge } from '#/types/models/filial'
import {
  checkboxRules,
  nameRules,
  phoneRules,
  regexName,
  regexNumber,
  validateField,
  validateLength,
} from '#/utils/helpers/rules'
import { options } from '#/utils/helpers/maska'
import Modal from '#/components/shared/modal.vue'
import Button from '#/components/shared/button.vue'
import type { ResultModal } from '#/types/shared/common'

interface Props {
  lounge: Lounge
}

defineProps<Props>()
const emits = defineEmits<{ submit: [ResultModal] }>()
const modal = defineModel<boolean>()
const stores = setupStore(['city'])

const formData = reactive({
  fullName: '',
  phoneNumber: '',
  privatePolice: false,
})

const modalProps = computed(() => ({
  title: 'Оформление',
  subTitle: `Лаунж зона`,
}))

const guard = ref(true)

async function submitForm() {
  if (
    guard.value
  )
    return
  try {
    guard.value = true
    await api.booking.postBooking({
      booking: {
        name: formData.fullName,
        phone: formData.phoneNumber,
        type: 'Лаунж',
        city_id: stores.city.selectedCity.id,
      },
    })
    emits('submit', { status: 'success', info: modalProps.value })
  }
  catch (e) {
    emits('submit', { status: 'failed', info: modalProps.value })
  }
  finally {
    formData.fullName = ''
    formData.phoneNumber = ''
    formData.privatePolice = false
    modal.value = false
  }
}

watch(formData, (newValue, _oldValue) => {
  const allFieldsValid = (
    validateField(newValue.fullName, regexName)
    && validateLength(newValue.fullName)
    && validateField(newValue.phoneNumber, regexNumber)
    && newValue.privatePolice
  )
  if (allFieldsValid)
    guard.value = false
  else
    guard.value = true
}, { deep: true, immediate: true })
</script>

<template>
  <Modal v-model="modal" custom-class="custom-modal" v-bind="modalProps">
    <template #content>
      <div class="content-wrapper">
        <v-form class="form">
          <v-text-field
            v-model="formData.fullName"
            :rules="nameRules"
            color="primary"
            variant="underlined"
            label="Имя"
            required
          />
          <v-text-field
            v-model="formData.phoneNumber"
            v-maska:[options]
            :rules="phoneRules"
            required
            color="primary"
            variant="underlined"
            label="Мобильный телефон"
          />
          <div class="price-info">
            <h3>
              {{ lounge.price_per_half_hour }}₽/30 мин •
              {{ lounge?.price_per_hour }}₽/60 мин
            </h3>
          </div>
        </v-form>
      </div>
    </template>
    <template #footer>
      <div class="footer-checkbox">
        <v-checkbox
          v-model="formData.privatePolice"
          :class="{ active: formData.privatePolice }"
          :rules="checkboxRules"
          required
          label="Я даю согласие на обработку персональных данных"
        />
        <Button
          name="Оформить заявку"
          type="submit"
          :button-light="true"
          :button-disabled="guard"
          @click="submitForm"
        />
      </div>
    </template>
  </Modal>
</template>

<style scoped lang="scss">
.active {
  color: $color-base2;
}

.form {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
}

.content-wrapper {
  display: flex;
  flex-direction: column;
  gap: $cover-32;
}

.price-info {
  display: flex;
  align-items: center;
  gap: $cover-8;
}
.footer-checkbox {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
}

input h2 {
  color: $color-opacity06;
}

h3 {
  color: $color-base2;
}
</style>

<style lang="scss">
@media screen and (max-width: 600px) {
  .custom-modal .modal-wrapper {
    border-radius: 0%;
  }
}
</style>
