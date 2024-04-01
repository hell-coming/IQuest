<script setup lang="ts">
interface Props {
  name?: string
}

const props = defineProps<Props>()
const imageSrc = ref(`/icons/genre/${props.name}.png`)
const showImage = ref(true)

function checkImageExists(url: string) {
  return new Promise((resolve) => {
    const img = new Image()
    img.src = url
    img.onload = () => resolve(true)
    img.onerror = () => resolve(false)
  })
}

// Проверяем, существует ли изображение в текущей папке
checkImageExists(imageSrc.value).then((exists) => {
  if (!exists) {
    imageSrc.value = `/icons/type/${props.name}.png`
    checkImageExists(imageSrc.value).then((stillExists) => {
      if (!stillExists)
        showImage.value = false // Не отображаем изображение, если не найдено
    })
  }
})

// Если имя изменяется, обновляем путь к изображению
watch(
  () => props.name,
  (newName) => {
    imageSrc.value = `/icons/genre/${newName}.png`
    checkImageExists(imageSrc.value).then((exists) => {
      if (!exists) {
        imageSrc.value = `/icons/type/${newName}.png`
        checkImageExists(imageSrc.value).then((stillExists) => {
          if (!stillExists)
            showImage.value = false // Не отображаем изображение, если не найдено
        })
      }
    })
  },
)
</script>

<template>
  <div class="tag">
    <img v-if="showImage" :src="imageSrc" :alt="props.name">
    <span class="smallFootnote">{{ props.name }}</span>
  </div>
</template>

<style scoped lang="scss">
.tag {
  display: flex;
  padding: $cover-8 $cover-12;
  gap: $cover-8;
  align-items: center;
  border-radius: 120px;
  border: 1px solid $color-opacity004;
  background: transparent;

  @media screen and (max-width: 375px) {
    gap: $cover-4;

    img {
      width: 16px;
    }
  }
}
</style>
