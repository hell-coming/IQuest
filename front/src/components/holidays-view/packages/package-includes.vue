<script setup lang="ts">
import AssistChip from '#/components/quest-view/quest/info/assist-chip.vue'

const props = defineProps<{ description?: string }>()

const itemsArray = ref<string[]>([])

function parseHTML(htmlString: string) {
  const parser = new DOMParser()
  const doc = parser.parseFromString(htmlString, 'text/html')
  const listItems = Array.from(doc.querySelectorAll('li'))
  return listItems.map(item => item.textContent || '')
}

function updateData() {
  if (props.description) {
    const description = props.description || ''
    itemsArray.value = parseHTML(description)
  }
}

watch(() => props.description, () => {
  updateData()
})

updateData()
</script>

<template>
  <div v-if="itemsArray.length > 0" class="includes">
    <h3>В пакет включено</h3>
    <div class="includes__items">
      <AssistChip
        v-for="(item, index) in itemsArray"
        :key="index"
        class="assist-chip"
        :name="item"
      />
      <ul class="mobile-list">
        <li v-for="(item, index) in itemsArray" :key="index" class="footnote ">
          {{ item }}
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped lang="scss">
.includes {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: clamp($cover-16, 3vw, $cover-32);
  align-self: stretch;

  &__items {
    display: flex;
    align-items: flex-start;
    align-content: flex-start;
    gap: $cover-16;
    align-self: stretch;
    flex-wrap: wrap;
  }

  h3 {
    color: $color-base2;
  }
}

.mobile-list {
  display: none;
  gap: $cover-12;
  flex-direction: column;

  li {
    list-style-type: none;
    display: flex;
    align-items: center;
  }

  li::before {
    content: '';
    width: 14px;
    height: 14px;
    background-image: url('/icons/share/star.svg');
    background-size: contain;
    background-repeat: no-repeat;
    margin-right: 6px;
  }
}

@media screen and (max-width: 600px) {
  .assist-chip {
    display: none;
  }

  .mobile-list {
    display: flex;
  }
}
</style>
