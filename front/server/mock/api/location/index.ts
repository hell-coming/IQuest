import type { Express } from 'express'
import { locationRoutes } from './location.routes'

export function init(server: Express, routePrefix = '/api') {
  locationRoutes(server, routePrefix)
}
