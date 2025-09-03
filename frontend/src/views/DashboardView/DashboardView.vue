<template>
  <div class="q-pa-md dashboard flex flex-center">
    <div class="full-width" style="max-width: 1200px">
      <q-card class="q-pa-md q-mb-md shadow-lg bg-grey-1">
        <div class="row q-col-gutter-md items-end">
          <div class="col-md-4 col-12">
            <q-input
              v-model="filters.titulo"
              label="Título"
              dense outlined rounded clearable
              @update:model-value="applyFilter('titulo', filters.titulo)"
            >
              <template v-slot:prepend>
                <q-icon name="search"/>
              </template>
            </q-input>
          </div>
          <div class="col-md-4 col-12">
            <q-select
              v-model="filters.autor"
              label="Autor"
              dense outlined rounded clearable
              emit-value map-options
              :options="filterStore.autores"
              @update:model-value="applyFilter('autor', filters.autor)"
            >
              <template v-slot:prepend>
                <q-icon name="person"/>
              </template>
            </q-select>
          </div>
          <div class="col-md-4 col-12">
            <q-select
              v-model="filters.assunto"
              label="Assunto"
              dense outlined rounded clearable
              emit-value map-options
              :options="filterStore.assuntos"
              @update:model-value="applyFilter('assunto', filters.assunto)"
            >
              <template v-slot:prepend>
                <q-icon name="menu_book"/>
              </template>
            </q-select>
          </div>          
        </div>
      </q-card>

      <div class="q-mb-md flex justify-end">
        <q-btn
          label="Novo Livro"
          icon="add"
          color="primary"
          size="xs"
          rounded
          unelevated
          glossy
          @click="criarLivro"
        />
      </div>

      <q-card flat bordered class="shadow-2">
        <q-table
          :rows="requestStore.requests"
          :columns="columns"
          row-key="Codl"
          flat
          dense
          bordered
          square
          :rows-per-page-options="[5,10,15]"
          row-hover
          wrap-cells
        >
          <template v-slot:body-cell-authors="props">
            <q-td :props="props">
              <q-chip
                v-for="author in props.row.authors"
                :key="author.CodAu"
                dense outline
                class="q-mr-sm"
                color="primary"
                text-color="white"
              >
                {{ author.Nome }}
              </q-chip>
            </q-td>
          </template>

          <template v-slot:body-cell-subjects="props">
            <q-td :props="props">
              <q-chip
                v-for="subject in props.row.subjects"
                :key="subject.CodAs"
                dense outline
                class="q-mr-sm"
                color="secondary"
                text-color="white"
              >
                {{ subject.Descricao }}
              </q-chip>
            </q-td>
          </template>

          <template v-slot:body-cell-actions="props">
            <q-td :props="props" class="text-center">
              <q-btn size="sm" dense color="green" icon="visibility" round flat @click="viewBook(props.row)" />
              <q-btn size="sm" dense color="blue" icon="edit" round flat @click="editBook(props.row)" />
              <q-btn size="sm" dense color="red" icon="delete" round flat @click="deleteBook(props.row)" />
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
import { useDashboardScript } from './DashboardView.js'
import './DashboardView.scss'

const {
  requestStore,
  filters,
  pagination,
  applyFilter,
  criarLivro,
  filterStore,
  columns
} = useDashboardScript()



function viewBook(book) {
  console.log('Visualizar', book)
}
function editBook(book) {
  console.log('Editar', book)
}
function deleteBook(book) {
  console.log('Excluir', book)
}
</script>

<style scoped>
.dashboard {
  max-width: 100%;
}

.q-table tr:hover {
  background-color: #e0f7fa;
}

.q-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.q-btn {
  margin: 0 2px;
}
</style>
