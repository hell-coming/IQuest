import type { AxiosInstance } from 'axios'
import type { BookingPayload } from './booking.type'

export default (instance: AxiosInstance) => ({
  postBooking(payload: BookingPayload): Promise<void> {
    return instance.post('/bookings', payload)
  },
})
