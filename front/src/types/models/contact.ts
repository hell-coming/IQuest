export interface Contact {
  id: number
  type: {
    id: number
    name: string
    is_social: boolean
  }
  value: string
}
