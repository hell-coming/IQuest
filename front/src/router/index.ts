import type { NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw, Router } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'
import { EAppRouteNames, EAppRoutePaths } from '#/types/routes'

import { useGlobalStore } from '#/stores/common/global.store'

const Home = () => import('#/views/home.vue')
const Quest = () => import('#/views/quest.vue')
const Contacts = () => import('#/views/contacts.vue')
const Certificat = () => import('#/views/certificates.vue')
const Holidays = () => import('#/views/holidays.vue')
const Lounge = () => import('#/views/lounge.vue')
const Error = () => import('#/views/error.vue')

const routes: RouteRecordRaw[] = [
  {
    path: EAppRoutePaths.Home,
    name: EAppRouteNames.Home,
    component: Home,
  },
  {
    path: EAppRoutePaths.Quest,
    name: EAppRouteNames.Quest,
    component: Quest,
  },
  {
    path: EAppRoutePaths.Contacts,
    name: EAppRouteNames.Contacts,
    component: Contacts,
  },
  {
    path: EAppRoutePaths.Holidays,
    name: EAppRouteNames.Holidays,
    component: Holidays,
  },
  {
    path: EAppRoutePaths.Certificat,
    name: EAppRouteNames.Certificat,
    component: Certificat,
  },
  {
    path: EAppRoutePaths.Lounge,
    name: EAppRouteNames.Lounge,
    component: Lounge,
  },
  {
    path: EAppRoutePaths.NotFound,
    name: EAppRouteNames.NotFound,
    component: Error,
  },
]

const router: Router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(
  async (
    _to: RouteLocationNormalized,
    _from: RouteLocationNormalized,
    next: NavigationGuardNext,
  ) => {
    useGlobalStore().setLoading(true)
    await nextTick()
    if (_to.matched.length === 0)
      next({ name: EAppRouteNames.NotFound })
    else
      next()
  },
)

router.afterEach(() => {
  useGlobalStore().setLoading(false)
})

export default router
