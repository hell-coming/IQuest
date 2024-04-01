export interface SearchContactRequest {
  include: string[]
  filter: {
    city_id: number
  }
}
