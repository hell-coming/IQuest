export interface SearchHolidayRequest {
  include: string[]
  filter: {
    is_active: boolean
  }
}
