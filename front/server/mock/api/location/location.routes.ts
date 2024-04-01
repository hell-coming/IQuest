import type { Express } from 'express'
import { LocationController } from './location.controller'

export function locationRoutes(server: Express, routePrefix?: string) {
  const controller = new LocationController()

  /*
   *  Тип:        POST
   *  Эндпоинт:   /filials:search
   *  Назначение:
   *  Примечание:
   */
  server.post(`${routePrefix}/filials:search`, controller.postFilials)
}
