<script setup lang="ts">
import HeaderComponent from '#/components/header-component.vue'
import FooterComponent from '#/components/footer-component.vue'

const stores = setupStore(['global'])

stores.global.initializeApp()
</script>

<template>
  <div class="main-container">
    <HeaderComponent />
    <router-view class="main" />
    <FooterComponent />
  </div>
</template>

<style scoped lang="scss">
.main {
  flex: 1;

  &-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
}

.footer {
  margin-top: auto;
}
</style>
