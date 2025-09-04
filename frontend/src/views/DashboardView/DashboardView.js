import { onMounted, reactive, watch } from 'vue'
import { useRequestStore } from '../../stores/requests'
import { useFilterStore } from '../../stores/filters'

export function useDashboardScript({ selectedBook, showModal, deleting }) {
  const requestStore = useRequestStore()
  const filterStore = useFilterStore()

  const filters = reactive({
    titulo: '',
    autor: '',
    assunto: ''
  })

  watch(filters, (newFilters) => {
    Object.keys(newFilters).forEach(key => requestStore.filters[key] = newFilters[key])
    requestStore.fetchRequests(1)
  }, { deep: true })

  const columns = [
    { name: 'Codl', label: 'ID', field: 'Codl', align: 'center', sortable: true },
    { name: 'Titulo', label: 'Título', field: 'Titulo', align: 'center', sortable: true },
    { name: 'Editora', label: 'Editora', field: 'Editora', align: 'center', sortable: true },
    { name: 'Edicao', label: 'Edição', field: 'Edicao', align: 'center', sortable: true },
    { name: 'AnoPublicacao', label: 'Ano', field: 'AnoPublicacao', align: 'center', sortable: true },
    { name: "valor", label: "Valor (R$)", field: "valor", align: "center", sortable: true },
    { name: 'authors', label: 'Autor', align: 'center', field: row => row.authors.map(a => a.Nome).join(', ') },
    { name: 'subjects', label: 'Assunto', align: 'center', field: row => row.subjects.map(s => s.Descricao).join(', ') },
    { name: 'actions', label: 'Ações', align: 'center', field: 'actions' }
  ]

  function abrirModalLivro() {
    selectedBook.value = {}
    showModal.value = true
  }

  function editBook(book) {
    selectedBook.value = { ...book }
    showModal.value = true
  }

  function deleteBook(book) {
    if (!book || !book.Codl) return
    if (window.confirm(`Deseja realmente excluir o livro "${book.Titulo}"?`)) {
      deleting.value = true
      requestStore.deleteBook(book.Codl).finally(() => deleting.value = false)
    }
  }

  async function handleSave(book, done) {
    try {
      if (book.Codl) await requestStore.updateBook(book.Codl, book)
      else await requestStore.createBook(book)
      done()
    } catch (err) {
      console.error(err)
      done()
    }
  }

  onMounted(() => {
    filterStore.fetchFilters()
    requestStore.fetchRequests(1)
  })

  return {
    requestStore,
    filterStore,
    filters,
    columns,
    abrirModalLivro,
    editBook,
    deleteBook,
    handleSave
  }
}
