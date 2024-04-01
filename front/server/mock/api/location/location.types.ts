export interface Filials {
  id: number
  address: string
  width: string
  longitude: string
  city: City
  lounges: Lounge[]
}

interface City {
  id: number
  name: string
}

interface Lounge {
  id: number
  name: string
  description: string
  cover: string
  max_people: number
  price_per_half_hour: string
  price_per_hour: string
}

//* Request *//

export interface PostFilialsReq {
  include: ('city' | 'lounges')[]
  filter: {
    city_id: number
  }
}
