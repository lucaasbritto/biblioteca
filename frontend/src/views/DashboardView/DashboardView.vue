<template>
  <div class="q-pa-md dashboard flex flex-center">
    <div v-if="deleting" class="fullscreen-loading">
      <q-spinner color="primary" size="50px" />
    </div>
    <div class="full-width" style="max-width: 1200px">
      <q-card class="q-pa-md q-mb-md shadow-lg bg-grey-1">
        <div class="row q-col-gutter-md items-end">
          <div class="col-md-4 col-12">
            <q-input
              v-model="filters.titulo"
              label="Título"
              dense outlined rounded clearable
            >
              <template v-slot:prepend>
                <q-icon name="search"/>
              </template>
            </q-input>
          </div>
          <div class="col-md-4 col-12">
            <q-select
              v-model="filters.autor"
              :options="filterStore.autores"
              label="Autor"
              dense outlined rounded clearable
              emit-value map-options
            />
          </div>
          <div class="col-md-4 col-12">
            <q-select
              v-model="filters.assunto"
              :options="filterStore.assuntos"
              label="Assunto"
              dense outlined rounded clearable
              emit-value map-options
            />
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
          @click="abrirModalLivro"
        />
      </div>

      <q-card flat bordered class="shadow-2">
        <q-table
          :rows="requestStore.requests"
          :columns="columns"
          row-key="Codl"
          flat dense bordered square row-hover wrap-cells
          class="shadow-1 my-table"
          :loading="requestStore.loading"
          :rows-per-page="10"
          :rows-per-page-options="[10, 20, 50, 100]"
          style="color: #0083a0"
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

          <template v-slot:body-cell-valor="props">
            <q-td :props="props">
              {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(props.row.valor) }}
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
              <q-btn size="sm" dense color="blue" icon="edit" round flat @click="editBook(props.row)" />
              <q-btn size="sm" dense color="red" icon="delete" round flat @click="deleteBook(props.row)" />
            </q-td>
          </template>

          <template v-slot:no-data>
            <div class="text-center text-grey q-pa-md">Nenhum livro encontrado.</div>
          </template>
        </q-table>
      </q-card>

      <BookModal
        v-model="showModal"
        :book="selectedBook"
        :autor-options="filterStore.autores"
        :assunto-options="filterStore.assuntos"
        @save="handleSave"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useDashboardScript } from './DashboardView.js'
import BookModal from '@/components/Books/BookModal.vue'

const selectedBook = ref({})
const showModal = ref(false)
const deleting = ref(false)

const {
  requestStore,
  filterStore,
  filters,
  columns,
  abrirModalLivro,
  editBook,
  deleteBook,
  handleSave
} = useDashboardScript({ selectedBook, showModal, deleting })
</script>

<style lang="scss" >
    @use './DashboardView.scss';  
</style>
