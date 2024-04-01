<script setup lang="ts">
import Button from './button.vue'
import Card from '#/components/quest-card/card-component.vue'

const stores = setupStore(['questList', 'city'])
const route = useRoute()
</script>

<template>
  <section v-if="stores.questList.questList.length" class="cards container">
    <h2>Наши квесты</h2>
    <div class="d-flex cards-grid">
      <template v-for="quest in stores.questList.questList" :key="quest.id">
        <Card v-if="quest.id !== +route.params.id" :is-hover="true" :quest="quest" />
      </template>
    </div>
  </section>
  <template v-else>
    <div class="loading container">
      <div class="loading-container">
        <h2>Квестов <span class="gradient">пока что</span> нет, ожидайте</h2>
        <Button :button-light="true" name="Выбрать Томск" @click="stores.city.selectCity(stores.city.getFirstCity)" />
      </div>
    </div>
  </template>
</template>

<style scoped lang="scss">
h2 {
  color: $color-base2;
}

.loading {
  min-height: 85vh;
  display: flex;
  align-items: center;
  justify-content: center;

  h2 {
    text-align: center;
  }

  .gradient {
    background: $color-gradient;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  &-container {
    display: flex;
    flex-direction: column;
    gap: $cover-32;
    align-items: center;

    .button {
      max-width: 278px;
    }
  }
}

.cards {
  display: flex;
  flex-direction: column;
  gap: $cover-32;

  &-grid {
    align-items: center;
    align-content: center;
    gap: $cover-32;
    flex-wrap: wrap;
  }
}

@media screen and (max-width: 1400px) {
  .cards-grid {
    display: grid !important;
    grid-template-columns: 50% auto;

    :deep(div .card) {
      width: 100%;

      .card-image {
        width: 100%;
      }
    }
  }
}

@media screen and (max-width: 950px) {
  .cards-grid {
    grid-template-columns: 100%;
  }
}
</style>
