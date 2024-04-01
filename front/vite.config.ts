import { URL, fileURLToPath } from 'node:url'
import { defineConfig } from 'vite'
import { visualizer } from 'rollup-plugin-visualizer'
import vue from '@vitejs/plugin-vue'
import autoImport from 'unplugin-auto-import/vite'
import svgLoader from 'vite-svg-loader'
import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'

// import purgeCss from '@mojojoejo/vite-plugin-purgecss'

export default defineConfig({
  plugins: [
    vue({ template: { transformAssetUrls } }),
    svgLoader(),
    vuetify({
      autoImport: true,
      styles: { configFile: './src/assets/scss/_vuetify.scss' },
    }),
    visualizer(),
    autoImport({
      imports: ['vue', 'vue-router', 'pinia'],
      dts: './src/types/dts/auto-imports.d.ts',
      dirs: [
        './src/stores/',
        './src/stores/common/',
        './src/utils/api/',
        './src/utils/helpers/',
      ],
    }),
    // purgeCss({
    //   content: [
    //     'index.html',
    //     './src/**/*.ts',
    //     './src/**/*.html',
    //     './src/**/*.vue',
    //     './node_modules/vuetify/src/**/*.ts',
    //   ],
    //   safelist: [
    //     /-(leave|enter|appear)(|-(to|from|active))$/,
    //     /data-v-.*/,
    //     /^rounded-.*/,
    //     /^v-((?!application).)*$/,
    //     /.*-transition/,
    //   ],
    //   defaultExtractor(content) {
    //     // content without style blocks
    //     return content
    //       .replace(/<style[^]+?<\/style>/gi, '')
    //       .match(/[A-Za-z0-9-_/:]*[A-Za-z0-9-_/]+/g) || []
    //   },
    //   extractors: [{
    //     extractor: content => content.match(/[A-z0-9-:\\/]+/g) || [],
    //     extensions: ['html', 'vue', 'ts'],
    //   }],
    //   variables: true,
    // }),

  ],
  optimizeDeps: {
    exclude: ['vuetify'],
  },
  resolve: {
    alias: {
      '#': fileURLToPath(new URL('./src', import.meta.url)),
    },
    extensions: ['.js', '.json', '.jsx', '.mjs', '.ts', '.tsx', '.vue', '.store'],
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
            @import './src/assets/scss/_variables.scss';
          `,
      },
    },
  },
})
