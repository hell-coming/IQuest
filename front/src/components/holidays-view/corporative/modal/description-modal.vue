<script setup lang="ts">
import Modal from '#/components/shared/modal.vue'

interface Props {
  name: string
  description: string
}

const props = defineProps<Props>()
const modal = defineModel<boolean>()

const modalProps = computed(() => ({
  title: `${props.name}`,
}))
</script>

<template>
  <Modal v-model="modal" custom-class="desc-modal" v-bind="modalProps">
    <template #content>
      <p class="footnoteText">
        {{ description }}
      </p>
    </template>
  </Modal>
</template>

<style scoped lang="scss">
.footnoteText {
  max-height: 300px;
  padding-right: 10px;
  overflow: auto;
}

p::-webkit-scrollbar {
  width: 5px;
}

p::-webkit-scrollbar-track {
  background-color: unset;
}

p::-webkit-scrollbar-thumb {
  background-color: $color-opacity06;
  border-radius: 20px;
}
</style>

<style lang="scss">
@media screen and (max-width: 600px) {
  .desc-modal .modal-wrapper {
    height: auto !important;
    overflow: hidden;
    max-height: 400px;
    gap: $cover-16;

    max-width: 90%;
  }

  .desc-modal .modal-content {
    overflow: auto;
  }
}
</style>
