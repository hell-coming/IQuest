<script setup lang="ts">
import { vMaska } from 'maska'
import QuestRules from './quest-rules.vue'
import type { ResultModal } from '#/types/shared/common'
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
import Plus from '#/assets/svg/shared/plus.svg?component'
import Minus from '#/assets/svg/shared/minus.svg?component'
import InfoPopUpVue from '#/components/shared/info-pop-up.vue'
import type { TimeSlots } from '#/types/models/schedule'

import Button from '#/components/shared/button.vue'

interface Props {
  date: string | null
  item: TimeSlots
}
const props = defineProps<Props>()
const emits = defineEmits<{ submit: [ResultModal] }>()
const modal = defineModel<boolean>()
const stores = setupStore(['quest', 'city'])

const formData = reactive({
  people: stores.quest.quest?.min_people || 0,
  fullName: '',
  phoneNumber: '',
  addLoudge: false,
  privatePolice: false,
})

const totalPrice = computed(() => {
  const { price = '0' } = props.item
  const basePrice = Number.parseFloat(price)
  const additionalPeople = Math.max(formData.people - 4, 0)
  const additionalCost = additionalPeople * 500

  return basePrice + additionalCost
})

function addPeople(): void {
  if (stores.quest.quest?.max_people !== undefined
    && formData.people < stores.quest.quest?.max_people)
    formData.people++
}

function removePeople(): void {
  if (stores.quest.quest?.min_people !== undefined
    && formData.people > stores.quest.quest?.min_people)
    formData.people--
}

const modalProps = computed(() => ({
  title: 'Бронирование',
  subTitle: `${stores.quest.quest?.name} • ${props.date} • ${props.item?.time?.replace(/:00$/, '') ?? ''}`,
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
        type: 'Квест',
        city_id: stores.city.selectedCity.id,
      },
      schedule_quest: {
        timeslot_id: props.item?.id,
        count_participants: formData.people,
        final_price: totalPrice.value.toString(),
        comment: formData.addLoudge ? 'Хочу лаунж' : '',
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
            v-model.lazy.trim="formData.fullName"
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
        </v-form>
        <div class="count-wrapper">
          <span class="footnote">Кол-во человек</span>
          <div class="count">
            <Minus class="btn pointer" @click="removePeople" />
            <span class="body">{{ formData.people }}</span>
            <Plus class="btn pointer" @click="addPeople" />
          </div>
          <span v-if="formData.people > 4" class="smallFootnote ">
            если игроков больше 4 — доплата 500₽ за каждого
          </span>
        </div>
        <h3>Итого за квест: {{ totalPrice }}₽</h3>
      </div>
      <QuestRules />
    </template>
    <template #footer>
      <div class="footer-checkbox">
        <div class="footer-checkbox__lounge">
          <v-checkbox
            v-model="formData.addLoudge"
            :class="{ active: formData.addLoudge }"
            class="loudge"
            label="Хочу лаунж зону"
          />
          <InfoPopUpVue
            name="Отдохните и обсудите квест после игры"
          />
        </div>
        <v-checkbox
          v-model="formData.privatePolice"
          :class="{ active: formData.privatePolice }"
          :rules="checkboxRules"
          required
          label="Я даю согласие на обработку персональных данных"
        />
        <Button
          name="Забронировать"
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
.count-wrapper {
  display: flex;
  flex-direction: column;
  gap: $cover-8;
  .count {
    display: flex;
    align-items: center;
    gap: $cover-12;

    .btn {
      :deep() {
        rect {
          transition: all 0.15s ease-in-out;
        }
      }

      &:hover {
        :deep() {
          rect {
            fill-opacity: 0.25;
          }
        }
      }
    }
  }

  .footnote {
    color: $color-base2;
  }
}

.loudge {
  max-height: 32px;
}

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

.footer-checkbox {
  display: flex;
  flex-direction: column;
  gap: $cover-12;

  &__lounge {
    display: flex;
    align-items: center;
    gap: $cover-4;
  }
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
