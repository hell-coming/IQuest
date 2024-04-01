<script setup lang="ts">
interface Props {
  isSelected: boolean
}

defineProps<Props>()
</script>

<template>
  <div class="body chip pointer" :class="{ isSelected }">
    <span class="bracket">[</span>
    <span>
      <slot />
    </span>
    <span class="bracket">]</span>
  </div>
</template>

<style scoped lang="scss">
.chip {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: $cover-8 0;
  gap: $cover-4;
  transition: all 0.3s ease-in-out;

  span {
    color: $color-opacity06;
  }

  .bracket {
    visibility: hidden;
  }

  &:hover .bracket {
    visibility: visible;
  }
}

.isSelected {
  span {
    color: $color-base2;
  }

  .bracket {
    visibility: visible;
  }
}
</style>
