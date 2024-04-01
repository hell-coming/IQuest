<script setup lang="ts">
interface Button {
  name: string
  buttonLight?: boolean
  buttonDisabled?: boolean
  footnote?: boolean
}

defineProps<Button>()
</script>

<template>
  <div
    class="btn-container button pointer"
    :class="{ buttonLight, buttonDisabled }"
  >
    <span class="bodyBold" :class="{ footnote }">{{ name }}</span>
  </div>
</template>

<style scoped lang="scss">
.button {
  justify-content: center;
  border-radius: $cover-16;
  transition: $hover-anim-btn;
  background-color: $color-opacity004;

  &:hover {
    background-color: $color-opacity012;
  }
}

.buttonLight {
  background-color: $color-primary;

  &:hover {
    background-color: $color-light-primary;
  }
}

.footnote {
  color: $color-base2;
}

.buttonDisabled {
  opacity: 0.3;

  &:hover {
    background-color: $color-primary;
  }

  cursor: default;
}
</style>
