<script setup lang="ts">
import Link from '#/assets/svg/shared/link-quest.svg?url'

defineProps<{
  isActiveImg?: boolean
  isActiveLink?: boolean
}>()

const store = setupStore('contact')

const phoneNumber = ref({
  text: store.getPhone,
  img: 'phone',
  link: `tel:${store.getPhone}`,
})

watch(() => store.getPhone, () => {
  phoneNumber.value.text = store.getPhone
  phoneNumber.value.link = `tel:${store.getPhone}`
})
</script>

<template>
  <a v-if="store.getPhone" :href="phoneNumber.link" class="body" :class="{ isActiveLink }">
    <img v-if="isActiveImg === false" :src="`/icons/share/${phoneNumber.img}.svg`" :alt="phoneNumber.img">
    <sapn>{{ phoneNumber.text }}</sapn>
    <img v-if="isActiveLink" :src="Link">
  </a>
</template>

<style scoped lang="scss">
a {
  align-items: center;
  display: flex;
  gap: 8px;
  a {
    color: $color-base2;
  }

  img {
    width: clamp(22px, 5vw, $cover-28);
  }
}

@media screen and (max-width: 600px) {
  .isActiveLink {
    display: flex;
    padding: $cover-16 $cover-24;
    justify-content: space-between;
    align-items: center;
    border-radius: $cover-16;
    background: $color-opacity004;
  }
}
</style>
