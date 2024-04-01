<script setup lang="ts">
interface Props {
  isSelected: boolean
}

defineProps<Props>()
</script>

<template>
  <div class="chip pointer" :class="{ isSelected }">
    <span class="body">
      <slot />
    </span>
  </div>
</template>

<style scoped lang="scss">
.chip {
  white-space: nowrap;
  width: max-content;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 120px;
  background-color: $color-opacity004;
  padding: clamp(14px, 3vw, $cover-16) clamp($cover-28, 5vw, $cover-48);
  align-items: center;
  &:hover {
    background-color: $color-opacity012;
  }
}

.body {
  width: max-content;
}

.isSelected {
  background-color: $color-primary;

  &:hover {
    background-color: $color-primary;
  }
}
</style>
