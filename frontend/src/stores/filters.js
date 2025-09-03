import { defineStore } from 'pinia'
import api from '../api'

export const useFilterStore = defineStore('filters', {
  state: () => ({
    assuntos: [],
    autores: [],
    loading: false
  }),
  actions: {
    async fetchFilters() {
      this.loading = true
      try {
        const [assuntos, autores] = await Promise.all([
          api.get('/filters/assuntos'),
          api.get('/filters/autores')
        ])
        this.assuntos = assuntos.data
        this.autores = autores.data
      } finally {
        this.loading = false
      }
    }
  }
})
