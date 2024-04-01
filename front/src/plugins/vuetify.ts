import { createVuetify } from 'vuetify'
import { ru } from 'vuetify/locale'

import 'vuetify/styles'

const vuetify = createVuetify({
  locale: {
    locale: 'ru',
    fallback: 'ru',
    messages: { ru },
  },
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: '#7422d4',
          secondary: '#333682',
        },
      },
    },
  },
})

export default vuetify
