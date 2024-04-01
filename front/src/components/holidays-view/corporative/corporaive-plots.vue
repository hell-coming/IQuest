<script setup lang="ts">
import PlotCard from './plot-card.vue'
import PlotList from '#/utils/mock/plot-list'
</script>

<template>
  <div class="container">
    <div class="title">
      <h1>Сюжеты</h1>
      <img src="/gradient/gradient.png" alt="gradient">
    </div>
    <div class="plots-list">
      <PlotCard v-for="plot in PlotList" :key="plot.name" :info="plot" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.container {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 108px;
}
.title {
  position: absolute;
  height: clamp(150px, 33vw, 535px);

  h1 {
    position: sticky;
    top: 0;
    font-size: clamp(50px, 18vw, 259px);
    font-style: normal;
    font-weight: 600;
    line-height: normal;

    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 0.35) -20.8%,
      rgba(255, 255, 255, 0) 77.86%
    );
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    @media screen and (max-width: 600px) {
      top: 50px;
    }
  }

  img {
    width: 100%;
    position: absolute;
    bottom: clamp(1px, 2vw, 34px);
  }
}

.plots-list {
  margin-top: clamp(82px, 33vw, 341px);
  display: flex;
  flex-direction: column;
  gap: clamp(64px, 10vw, 108px);
}
</style>
