export interface SearchQuestsRequest {
  include: string[]
  filter: {
    city_id: number
    is_active: boolean
  }
}

export interface SearchScheduleQuestsRequest {
  include: string[]
  filter: {
    quest_id: string | number
    today?: boolean
    tomorrow?: boolean
    weekend?: boolean
    between?: string[]
  }
}
