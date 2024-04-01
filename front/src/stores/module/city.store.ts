import router from '#/router'
import type { City } from '#/types/models/city'

//* --- State ----------------------------------------------- *//
interface CityState {
  cities: City[]
  selectedCity: City
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useCityStore = defineStore('city', {
  state: (): CityState => ({
    cities: [],
    selectedCity: {} as City,
    error: {},
  }),
  getters: {
    getFirstCity: state => state.cities[0],
  },
  actions: {
    async fetchCities() {
      try {
        const response = await api.city.getCities({})
        this.cities = response.data.data
        const savedCityId = localStorage.getItem('city')

        if (savedCityId)
          this.selectedCity = this.cities.find(f => f.id === +savedCityId)!

        if (!this.selectedCity?.id)
          this.selectedCity = this.getFirstCity
      }
      catch (error) {
        this.error = error
      }
    },

    selectCity(city: City) {
      router.push('/')
      this.selectedCity = city
      localStorage.setItem('city', city.id.toString())
    },
  },

})
