<script setup lang="ts">
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'
import 'animate.css'

const rules = [
  'Ответственность за нанесенный ущерб ложится на участников игры',
  'Перед игрой все оставляют свои вещи',
  'Время игры ограничено, есть возможность продления за доплату',
  'К играм допускаются только трезвые участники',
]

const showRules = ref(false)

function toggleRules() {
  showRules.value = !showRules.value
}
</script>

<template>
  <div class="rules" :class="{ active: showRules }">
    <div class="rules__btn pointer" :class="{ active: showRules }" @click="toggleRules">
      <span class="smallFootnote">Правила игры</span>
      <Arrow :class="{ 'rotate-180': showRules }" />
    </div>
    <ul class="rules__content">
      <li v-for=" rule in rules " :key="rule" class="smallFootnote">
        {{ rule }}
      </li>
    </ul>
  </div>
</template>

<style scoped lang="scss">
.rules {
  display: flex;
  flex-direction: column;
  gap: $cover-16;

  max-height: 20px;
  overflow: hidden;
  transition: all 0.25s ease-in-out;

  &__btn {
    width: max-content;
    display: flex;
    align-items: center;
    gap: $cover-4;
  }

  :deep(svg) {
    transition: all 0.1s ease-in-out;
    stroke-opacity: 0.6;
  }

  &__content {
    margin-left: 15px;
  }
}

.rotate-180 {
  transform: rotate(180deg);
}

.active {
  max-height: 100%;
  animation: all 0.1s ease-in-out;

  span {
    color: $color-base2;
  }

  :deep(svg) {
    stroke-opacity: 1;
  }
}
</style>
