<script setup lang="ts">
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'

const props = defineProps<{ description: string }>()
const MAX_CHARS_TO_SHOW = 170

const isExpanded = ref(false)
const desc = ref(`${props.description.slice(0, MAX_CHARS_TO_SHOW)}...`)

function toggleExpand() {
  isExpanded.value = !isExpanded.value

  if (isExpanded.value) {
    desc.value = props.description
  }
  else {
    setTimeout (() => {
      desc.value = `${props.description.slice(0, MAX_CHARS_TO_SHOW)}...`
    }, 250)
  }
}

const truncatedDescription = computed(() => {
  if (props.description.length <= MAX_CHARS_TO_SHOW)
    return props.description

  return desc.value
})

const fullDescription = computed(() => {
  return isExpanded.value ? props.description : truncatedDescription.value
})

const expandButtonText = computed(() => {
  return isExpanded.value ? 'Свернуть' : 'Равернуть'
})

const shouldTruncate = computed(() => {
  return props.description.length >= MAX_CHARS_TO_SHOW
})
</script>

<template>
  <div class="description">
    <span class="bodyBold">Описание</span>
    <div class="description-content">
      <p class="footnote" :class="{ extend: isExpanded }" v-html="fullDescription" />
      <div
        v-if="shouldTruncate"
        class="read-more footnote pointer"
        :class="{ active: isExpanded }"
        @click="toggleExpand"
      >
        {{ expandButtonText }}
        <Arrow />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.read-more {
  width: max-content;
  display: flex;
  gap: $cover-8;
  align-items: center;
  transition: all 0.25s ease-in-out;
  color: $color-opacity06;

  :deep(svg) {
    transform: rotate(0);
    transition: all 0.1s ease-in-out;
    stroke-opacity: 0.6;
  }

  &.active {
    :deep(svg) {
      transform: rotate(180deg);
    }
  }
}

.description {
  display: flex;
  flex-direction: column;
  gap: $cover-12;

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-8;

    p {
      display: -webkit-box;
      -webkit-box-orient: vertical;
      overflow: hidden;
      transition: all 0.25s ease-in-out;
      max-height: 72px;
    }

    p.extend {
      max-height: 100%;
    }

    @media screen and (max-width: 600px) {
      gap: $cover-4;
    }
  }

  @media screen and (max-width: 600px) {
    gap: $cover-6;
  }
}
</style>
