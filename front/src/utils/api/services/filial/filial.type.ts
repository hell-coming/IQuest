export interface SearchFilialRequest {
  include: string[]
  filter: {
    city_id: number
    lounge_is_active: boolean
  }
}
