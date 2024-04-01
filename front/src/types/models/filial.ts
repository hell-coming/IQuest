export interface Filial {
  id: number
  address: string
  latitude: number
  longitude: number
  city: City
  lounges: Lounge[]
}
interface City {
  id: number
  name: string
}

export interface Lounge {
  id: number
  name: string
  description: string
  cover: string
  max_people: number
  price_per_half_hour: string
  price_per_hour: string
}
