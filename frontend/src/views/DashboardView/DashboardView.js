import { onMounted, reactive, watch, ref } from 'vue'
import { useRequestStore } from '../../stores/requests'
import { useFilterStore } from '../../stores/filters'
import api from '@/api' 
import { Notify } from 'quasar'

export function useDashboardScript({ selectedBook, showModal, deleting }) {
  const requestStore = useRequestStore()
  const filterStore = useFilterStore()

  const filters = reactive({
    titulo: '',
    autor: '',
    assunto: ''
  })

  const downloading = ref(false)

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

  async function downloadReport() {
    downloading.value = true

    Notify.create({
      message: 'Aguarde, gerando relatório...',
      color: 'info',
      icon: 'hourglass_top',
      position: 'top-right',
      timeout: 2000
    })

    try {
      const response = await api.get("/report/books", {
        responseType: "blob",
      })

      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement("a")
      link.href = url
      link.setAttribute("download", "relatorio_livros.xlsx")
      document.body.appendChild(link)
      link.click()
      link.remove()
      
      Notify.create({
        message: 'Relatório pronto para download!',
        color: 'positive',
        icon: 'check',
        position: 'top-right',
        timeout: 3000
      })

    } catch (error) {
      console.error("Erro ao baixar relatório:", error)
      Notify.create({
        message: 'Erro ao gerar o relatório.',
        color: 'negative',
        icon: 'error',
        position: 'top-right',
        timeout: 3000
      })
    } finally {
      downloading.value = false
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
    handleSave,
    downloadReport,
    downloading
  }
}
