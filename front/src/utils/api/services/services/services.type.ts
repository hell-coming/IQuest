export interface SearchServicesRequest {
  include: string[]
  filter: {
    city_id: number
  }
}
