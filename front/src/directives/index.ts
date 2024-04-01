import type { App } from 'vue'

import { LazySrcDirective } from './lazy-src'

export function initCustomDirectives(app: App<Element>): App<Element> {
  const clonedApp = { ...app }

  clonedApp.directive('lazy-src', LazySrcDirective)

  return clonedApp
}
