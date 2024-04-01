<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')

const email = ref({
  text: store.getEmail,
  img: 'mail',
  link: `mailto:${store.getEmail}`,
})

watch(() => store.getEmail, () => {
  email.value.text = store.getEmail
  email.value.link = `mailto:${store.getEmail}`
})
</script>

<template>
  <a v-if="store.getEmail" :href="email.link" class="body">
    <img v-if="isActiveImg === false" :src="`/icons/share/${email.img}.svg`" :alt="email.img">
    <span>{{ email.text }}</span>
  </a>
</template>

<style scoped lang="scss">
  a {
  display: flex;
  align-items: center;
  gap: 8px;

  span {
    color: $color-base2;
  }
}
</style>
