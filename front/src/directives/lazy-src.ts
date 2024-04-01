import type { Directive } from 'vue'

export const LazySrcDirective: Directive = {
  mounted(el: Element, binding: { value: string }) {
    const options = {
      rootMargin: '0px 0px 200px 0px',
    }
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = new Image()
          img.src = binding.value
          img.addEventListener('load', () => {
            el.setAttribute('src', binding.value)
            el.classList.add('loaded')
          })
          img.addEventListener('error', () => {
            el.setAttribute('src', '/img/not-found.gif')
            el.classList.add('error')
          })

          observer.disconnect()
        }
      })
    }, options)
    observer.observe(el)
  },
}
