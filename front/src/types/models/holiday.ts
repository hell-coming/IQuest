export interface Holiday {
  id: number
  type: string
  packages: Packages[]
}

export interface Packages {
  id: number
  name: string
  description: string
  price: string
  sequence_number: number
}
