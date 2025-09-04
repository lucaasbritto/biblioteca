<template>
  <div class="q-pa-md dashboard flex flex-center">
    <div v-if="deleting" class="fullscreen-loading">
      <q-spinner color="primary" size="50px" />
    </div>

    <div class="full-width" style="max-width: 1200px">

      <q-card class="q-pa-md q-mb-md shadow-lg bg-grey-1">
        <div class="row q-col-gutter-md items-end">
          <div class="col-md-12 col-12">
            <q-input
              v-model="filters.name"
              label="Nome"
              dense outlined rounded clearable
            >
              <template v-slot:prepend>
                <q-icon name="search"/>
              </template>
            </q-input>
          </div>
        </div>
      </q-card>

      <div class="q-mb-md flex justify-end">
        <q-btn
          label="Novo Autor"
          icon="add"
          color="primary"
          size="xs"
          rounded
          unelevated
          glossy
          @click="openModalAutor"
        />
      </div>

      <q-card flat bordered class="shadow-2">
        <q-table
          :rows="authors"
          :columns="columns"
          row-key="CodAu"
          flat dense bordered square row-hover wrap-cells
          :loading="loading"
          class="shadow-1 my-table"
          :rows-per-page-options="[10, 20, 50, 100]"
          :rows-number="totalAuthors"
          @request="handlePagination"
          style="color: #0083a0"
        >
          <template v-slot:body-cell-actions="props">
            <q-td :props="props" class="text-center">
              <q-btn size="sm" dense color="blue" icon="edit" round flat @click="editAutor(props.row)" />
              <q-btn size="sm" dense color="red" icon="delete" round flat @click="deleteAutor(props.row)" />
            </q-td>
          </template>

          <template v-slot:no-data>
            <div class="text-center text-grey q-pa-md">Nenhum autor encontrado.</div>
          </template>
        </q-table>
      </q-card>

      <q-dialog v-model="showModal" persistent>
        <q-card class="q-pa-md" style="min-width: 400px; max-width: 500px;">
          <q-card-section>
            <div class="text-h6 q-mb-md">{{ modalTitle }}</div>
            <q-input
              v-model="localAuthor.Nome"
              label="Nome do Autor"
              outlined dense autofocus
              :rules="[val => !!val || 'Nome obrigatório']"
            />
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="Cancelar" color="grey" @click="closeModal" />
            <q-btn
              color="primary"
              :label="actionLabel"
              :disable="!localAuthor.Nome"
              :loading="saving"
              @click="saveAuthor"
            />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watch } from "vue";
import { getAuthors, createAuthor, updateAuthor, deleteAuthor } from "../../api/requests";
import { Dialog, Notify } from "quasar";

const authors = ref([]);
const filters = reactive({ name: "", page: 1, per_page: 10 });
const loading = ref(false);
const deleting = ref(false);
const totalAuthors = ref(0);

const showModal = ref(false);
const saving = ref(false);
const localAuthor = reactive({ Nome: "", CodAu: null });

const modalTitle = computed(() => localAuthor.CodAu ? "Editar Autor" : "Novo Autor");
const actionLabel = computed(() => localAuthor.CodAu ? "Editar" : "Salvar");

const columns = [
  { name: "CodAu", label: "ID", field: "CodAu", align: "center", sortable: true, style: "width: 80px" },
  { name: "Nome", label: "Nome", field: "Nome", align: "left", sortable: true , style: "min-width: 300px; width: 60%" },
  { name: "actions", label: "Ações", field: "actions", align: "center", style: "width: 150px" }
];

const pagination = reactive({
  page: filters.page,
  rowsPerPage: filters.per_page,
  rowsNumber: totalAuthors.value
});

async function fetchAuthors() {
  loading.value = true;
  try {
    const response = await getAuthors(filters);
    authors.value = response.data;
    totalAuthors.value = response.total;
    pagination.rowsNumber = response.total;
  } catch (error) {
    console.error(error);
    Notify.create({ type: "negative", message: "Erro ao carregar autores" });
  } finally {
    loading.value = false;
  }
}


watch(filters, fetchAuthors, { deep: true });


function handlePagination(pag) {
  filters.page = pag.page;
  filters.per_page = pag.rowsPerPage;
}


function openModalAutor() {
  localAuthor.Nome = "";
  localAuthor.CodAu = null;
  showModal.value = true;
}

function editAutor(author) {
  localAuthor.Nome = author.Nome;
  localAuthor.CodAu = author.CodAu;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
}


async function saveAuthor() {
  if (!localAuthor.Nome) return;
  saving.value = true;
  try {
    if (localAuthor.CodAu) {
      await updateAuthor(localAuthor.CodAu, { name: localAuthor.Nome });
      Notify.create({ type: "positive", message: "Autor atualizado com sucesso!" });
    } else {
      await createAuthor({ name: localAuthor.Nome });
      Notify.create({ type: "positive", message: "Autor criado com sucesso!" });
    }
    fetchAuthors();
    closeModal();
  } catch (error) {
    console.error(error);
    Notify.create({ type: "negative", message: "Erro ao salvar autor" });
  } finally {
    saving.value = false;
  }
}


function deleteAutor(author) {
  Dialog.create({
    title: "Confirmar",
    message: `Deseja realmente excluir o autor "${author.Nome}"?`,
    cancel: true,
    persistent: true
  }).onOk(async () => {
    deleting.value = true;
    try {
      await deleteAuthor(author.CodAu);
      Notify.create({ type: "positive", message: "Autor excluído" });
      fetchAuthors();
    } catch (error) {
      console.error(error);
      Notify.create({ type: "negative", message: "Erro ao deletar autor" });
    } finally {
      deleting.value = false;
    }
  });
}


onMounted(() => {
  fetchAuthors();
});
</script>

<style scoped>
.rounded-borders { border-radius: 12px; }
.fullscreen-loading {
  position: fixed;
  top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.3);
  display: flex;
  justify-content:center;
  align-items:center;
  z-index: 9999;
}
</style>
