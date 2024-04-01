import type { Request, Response } from 'express'
import { LocationService } from './location.service'

export class LocationController {
  private service = new LocationService()

  postFilials = async (req: Request, res: Response) => {
    try {
      const result = await this.service.getFilials(req.body)

      return res.status(200).send(result)
    }
    catch (e) {
      return res.status(500).send(e)
    }
  }
}
