import type { Express } from 'express'
import * as Location from './api/location'

export function setupMockControllers(server: Express) {
  Location.init(server)
}
