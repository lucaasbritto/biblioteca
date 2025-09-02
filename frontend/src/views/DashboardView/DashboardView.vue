<template>
  <div class="q-pa-md dashboard flex flex-center">
    <div class="full-width" style="max-width: 1000px">
      <q-card class="q-pa-md q-mb-md shadow-2">
        <div class="row q-col-gutter-sm items-end">
          <div class="col-md-5 col-12">
            <q-input
              v-model="filters.search"
              label="Título ou Autor"
              dense
              outlined
              rounded
              debounce="300"
              @update:model-value="applyFilter('search', filters.search)"
            />
          </div>
          <div class="col-md-4 col-12">
            <q-input
              v-model="filters.data_publicacao"
              label="Data de Publicação"
              type="date"
              dense
              outlined
              rounded
              @update:model-value="applyFilter('data_publicacao', filters.data_publicacao)"
            />
          </div>
          <div class="col-md-3 col-12">
            <q-select
              v-model="filters.assunto"
              label="Assunto"
              dense
              outlined
              rounded
              emit-value
              map-options
              :options="assuntoOptions"
              @update:model-value="applyFilter('assunto', filters.assunto)"
            />
          </div>                  
        </div>
      </q-card>

      <div class="q-mb-md text-right">
        <q-btn
          label="Novo Livro"
          icon="add"
          color="primary"
          size="sm"
          dense
          rounded
          unelevated
          @click="criarLivro"
        />
      </div>

      <q-card flat bordered>
        <q-table
          :rows="rows"
          :columns="columns"
          row-key="id"
          dense
          flat
          bordered
          class="shadow-1"
        >
          <template v-slot:body-cell-valor="props">
            <q-td :props="props">
              R$ {{ props.row.valor.toFixed(2) }}
            </q-td>
          </template>

          <template v-slot:body-cell-data_publicacao="props">
            <q-td :props="props">
              {{ formatDateBR(props.row.data_publicacao) }}
            </q-td>
          </template>

          <template v-slot:no-data>
            <div class="text-center text-grey q-pa-md">Nenhum livro encontrado.</div>
          </template>
        </q-table>
      </q-card>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const filters = ref({
  search: '',
  data_publicacao: '',
  assunto: ''
})

const assuntoOptions = [
  { label: 'Todos', value: '' },
  { label: 'Ficção', value: 'Ficção' },
  { label: 'História', value: 'História' },
  { label: 'Ciência', value: 'Ciência' }
]

const rows = ref([
  { id: 1, titulo: 'Livro A', autor: 'Autor 1', assunto: 'Ficção', valor: 25.50, data_publicacao: '2025-01-15' },
  { id: 2, titulo: 'Livro B', autor: 'Autor 2', assunto: 'História', valor: 40.00, data_publicacao: '2024-12-05' },
  { id: 3, titulo: 'Livro C', autor: 'Autor 1', assunto: 'Ciência', valor: 30.75, data_publicacao: '2025-02-20' },
])

const columns = [
  { name: 'id', label: '#', field: 'id', align: 'left' },
  { name: 'titulo', label: 'Título', field: 'titulo', align: 'left' },
  { name: 'autor', label: 'Autor', field: 'autor', align: 'left' },
  { name: 'assunto', label: 'Assunto', field: 'assunto', align: 'left' },
  { name: 'valor', label: 'Valor (R$)', field: 'valor', align: 'left' },
  { name: 'data_publicacao', label: 'Data de Publicação', field: 'data_publicacao', align: 'left' },
]

const formatDateBR = (dateStr) => {
  const d = new Date(dateStr)
  return d.toLocaleDateString('pt-BR')
}

const applyFilter = (field, value) => {
  console.log('Filtrar', field, value)
  }

const criarLivro = () => {
  console.log('Abrir modal para criar livro')
}

onMounted(() => {
  console.log('Dashboard de livros montado')
})
</script>

<style scoped>
.dashboard {
  max-width: 100%;
}
</style>
