<script setup lang="ts">
import Modal from '#/components/shared/modal.vue'

const modal = defineModel<boolean>()
const stores = setupStore(['city'])

const modalProps = computed(() => ({
  title: 'выбор города',
}))
</script>

<template>
  <Modal v-model="modal" custom-class="city-modal" v-bind="modalProps">
    <template #content>
      <div class="list">
        <h3
          v-for="element in stores.city.cities!"
          :key="element.id"
          class="pointer"
          @click="stores.city.selectCity(element)"
        >
          {{ element.name }}
        </h3>
      </div>
    </template>
  </Modal>
</template>

<style scoped  lang="scss">
.list {
  display: flex;
  flex-direction: column;

  h3 {
    padding: $cover-12 0;
  }
}
</style>

<style lang="scss">
@media screen and (max-width: 600px) {
  .city-modal .modal-wrapper {
    height: auto !important;
    overflow: hidden;
    max-height: 400px;
    gap: $cover-16;

    max-width: 90%;
  }

  .city-modal .modal-content {
    overflow: auto;
  }
}
</style>
