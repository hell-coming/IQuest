import { faker } from '@faker-js/faker'
import * as mockData from './data'

//* ---- HARDCODE data --------------------------------------------------------- *//

export function mockRepository() {
  return {
    filias: Array.from(
      { length: faker.number.int({ min: 1, max: 3 }) },
      () => mockData.filials(),
    ),
  }
}
