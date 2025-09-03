import { defineStore } from 'pinia'
import { getRequests, createBook, updateBook, deleteBook } from '../api/requests'

export const useRequestStore = defineStore('requests', {
  state: () => ({
    requests: [],
    pagination: {},
    loading: false,
    filters: {
      titulo: '',
      autor: '',
      assunto: ''
    },
  }),

  actions: {    
    async fetchRequests(page = 1) {
      this.loading = true
      try {
        const payload = {
          titulo: this.filters.titulo || '',
          autor: this.filters.autor || '',
          assunto: this.filters.assunto || '',
          page
        }

        const res = await getRequests(payload)
        this.requests = res.data 

        this.pagination = {
          currentPage: res.data.current_page,
          lastPage: res.data.last_page,
          perPage: res.data.per_page,
          total: res.data.total
        }
      } catch (err) {
        console.error('Erro ao buscar livros:', err)
      } finally {
        this.loading = false
      }
    },

    setFilter(key, value) {
      this.filters[key] = value
      this.fetchRequests(1)
    },

    changePage(page) {
      this.fetchRequests(page)
    },

    async createBook(payload) {
      try {
        await createBook(payload)
        await this.fetchRequests(1)
      } catch (err) {
        console.error('Erro ao criar livro:', err)
      }
    },

    async updateBook(id, payload) {
      try {
        await updateBook(id, payload)
        await this.fetchRequests(this.pagination.currentPage)
      } catch (err) {
        console.error('Erro ao atualizar livro:', err)
      }
    },

    async deleteBook(id) {
      try {
        this.loading = true;
        await deleteBook(id);
        
        this.requests = this.requests.filter(book => book.Codl !== id)

        if (this.requests.length === 0 && this.pagination.currentPage > 1) {
          this.pagination.currentPage--
        }

      } catch (err) {
        console.error('Erro ao deletar livro:', err);
      } finally {
        this.loading = false;
      }
    }
  }
})
