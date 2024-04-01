export interface BookingPayload {
  booking: {
    name: string
    phone: string
    type: 'Квест' | 'Лаунж' | 'Праздник' | 'Сертификат'
    city_id: number
  }
  schedule_quest?: {
    timeslot_id: number
    count_participants: number
    final_price: string
    comment: string
  }
  holiday?: {
    holiday_id: number
    package_id: number
  }
  certificate_type_id?: number
}
