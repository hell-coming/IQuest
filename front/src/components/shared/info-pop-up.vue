<script setup lang="ts">
import Info from '#/assets/svg/shared/info.svg?component'

interface Props {
  name: string
}

defineProps<Props>()
</script>

<template>
  <div class="info">
    <Info />
    <v-tooltip
      class="popUp"
      activator="parent"
      location="top"
    >
      <span class="smallFootnote">{{ name }}</span>
    </v-tooltip>
  </div>
</template>

<style scoped lang="scss">
.info {
  display: flex;
  align-items: center;
  width: max-content;
  height: max-content;
}
:deep(.v-overlay__content) {
  border-radius: 120px !important;
  padding: 12px 20px !important;
  background: $color-opacity004 !important;
  backdrop-filter: blur(24px) !important;
  border: 1px solid $color-opacity012 !important;
  top: 710px;
}

.smallFootnote {
  color: $color-base2;
}
</style>
