import type { AxiosError, AxiosInstance } from 'axios'

export function RequestErrorInterceptor(instance: AxiosInstance) {
  instance.interceptors.response.use(
    response => response,
    async (error: AxiosError) => {
      // Обработка ошибок запросов ...

      return await Promise.reject(error)
    },
  )
}
