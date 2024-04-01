<script setup lang="ts">
import OverlayLoader from '#/components/shared/owerlay-loader.vue'

defineProps<{ isLoading: boolean }>()
</script>

<template>
  <Transition name="faid">
    <OverlayLoader v-if="isLoading" class="owerlay-loading" />
    <template v-else>
      <slot />
    </template>
  </Transition>
</template>

<style scoped lang="scss">
.faid-enter-active,
.faid-leave-active {
  transition: opacity 0.5s ease;
}

.faid-enter-from,
.faid-leave-to {
  opacity: 0;
}

.owerlay-loading {
  position: fixed;
  width: 100%;
  height: 100%;
  background-color: rgb(20, 17, 22);
  z-index: 100;
}
</style>
