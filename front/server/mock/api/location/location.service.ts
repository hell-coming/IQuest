/* eslint-disable unused-imports/no-unused-vars */
import { mockRepository } from './location.model'
import type { Filials, PostFilialsReq } from './location.types'

export class LocationService {
  private repository = mockRepository()

  public async getFilials(search?: PostFilialsReq) {
    const data = await new Promise<Filials[]>(r => r(this.repository.filias))

    return { data }
  }
}
