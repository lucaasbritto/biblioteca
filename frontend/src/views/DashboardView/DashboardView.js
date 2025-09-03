import { onMounted, reactive, computed, watch } from 'vue'
import { useRequestStore } from '../../stores/requests'
import { useFilterStore } from '../../stores/filters'

export function useDashboardScript() {
  const requestStore = useRequestStore()
  const filterStore = useFilterStore()

  const filters = reactive({
    titulo: '',
    autor: '',
    assunto: ''
  })

  const pagination = computed(() => requestStore.pagination)

  const columns = [
    { name: 'Codl', label: 'ID', field: 'Codl', align: 'center', sortable: true },
    { name: 'Titulo', label: 'Título', field: 'Titulo', align: 'center', sortable: true },
    { name: 'Editora', label: 'Editora', field: 'Editora', align: 'center', sortable: true },
    { name: 'Edicao', label: 'Edição', field: 'Edicao', align: 'center', sortable: true },
    { name: 'AnoPublicacao', label: 'Ano', field: 'AnoPublicacao', align: 'center', sortable: true },
    { name: 'authors', label: 'Autores', align: 'center', field: row => row.authors.map(a => a.Nome).join(', ') },
    { name: 'subjects', label: 'Assuntos', align: 'center', field: row => row.subjects.map(s => s.Descricao).join(', ') },
    { name: 'actions', label: 'Ações', align: 'center', field: 'actions' }
  ]

  watch(filters, () => {
    requestStore.fetchRequests(filters)
  }, { deep: true })

  
  function criarLivro() {
    console.log('Abrir modal para criar livro')
  }

  onMounted(() => {
    filterStore.fetchFilters()
    requestStore.fetchRequests(filters)
  })

  return {
    requestStore,
    filterStore,
    filters,
    pagination,
    criarLivro,
    columns
  }
}
