export interface SearchStocksRequest {
  include: string[]
  filter: {
    city_id: number
    is_active: boolean
  }
}
