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
              label="Nome do Assunto"
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
          label="Novo Assunto"
          icon="add"
          color="primary"
          size="xs"
          rounded
          unelevated
          glossy
          @click="openModalSubject"
        />
      </div>

      <q-card flat bordered class="shadow-2">
        <q-table
          :rows="subjects"
          :columns="columns"
          row-key="codAs"
          flat dense bordered square row-hover wrap-cells
          :loading="loading"
          class="shadow-1 my-table"
          :rows-per-page-options="[10, 20, 50, 100]"
          :rows-number="totalSubjects"
          @request="handlePagination"
          style="color: #0083a0"
        >
          <template v-slot:body-cell-actions="props">
            <q-td :props="props" class="text-center">
              <q-btn size="sm" dense color="blue" icon="edit" round flat @click="editSubject(props.row)" />
              <q-btn size="sm" dense color="red" icon="delete" round flat @click="deleteSubject(props.row)" />
            </q-td>
          </template>

          <template v-slot:no-data>
            <div class="text-center text-grey q-pa-md">Nenhum assunto encontrado.</div>
          </template>
        </q-table>
      </q-card>

      <q-dialog v-model="showModal" persistent>
        <q-card class="q-pa-md" style="min-width: 400px; max-width: 500px;">
          <q-card-section>
            <div class="text-h6 q-mb-md">{{ modalTitle }}</div>
            <q-input
              v-model="localSubject.Descricao"
              label="Nome do Assunto"
              outlined dense autofocus
              :rules="[val => !!val || 'Nome obrigatório']"
            />
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="Cancelar" color="grey" @click="closeModal" />
            <q-btn
              color="primary"
              :label="actionLabel"
              :disable="!localSubject.Descricao"
              :loading="saving"
              @click="saveSubject"
            />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watch } from "vue";
import { getSubjects, createSubject, updateSubject, deleteSubject as apiDeleteSubject } from "../../api/requests";
import { Dialog, Notify } from "quasar";

const subjects = ref([]);
const filters = reactive({ name: "", page: 1, per_page: 10 });
const loading = ref(false);
const deleting = ref(false);
const totalSubjects = ref(0);

const showModal = ref(false);
const saving = ref(false);
const localSubject = reactive({ Descricao: "", codAs: null });

const modalTitle = computed(() => localSubject.codAs ? "Editar Assunto" : "Novo Assunto");
const actionLabel = computed(() => localSubject.codAs ? "Editar" : "Salvar");

const columns = [
  { name: "codAs", label: "ID", field: "codAs", align: "center", sortable: true, style: "width: 80px" },
  { name: "Descricao", label: "Nome", field: "Descricao", align: "left", sortable: true, style: "min-width: 300px; width: 60%" },
  { name: "actions", label: "Ações", field: "actions", align: "center", style: "width: 150px" }
];

const pagination = reactive({
  page: filters.page,
  rowsPerPage: filters.per_page,
  rowsNumber: totalSubjects.value
});

async function fetchSubjects() {
  loading.value = true;
  try {
    const response = await getSubjects(filters);
    subjects.value = response.data;
    totalSubjects.value = response.total;
    pagination.rowsNumber = response.total;
  } catch (error) {
    console.error(error);
    Notify.create({ type: "negative", message: "Erro ao carregar assuntos" });
  } finally {
    loading.value = false;
  }
}

watch(filters, fetchSubjects, { deep: true });

function handlePagination(pag) {
  filters.page = pag.page;
  filters.per_page = pag.rowsPerPage;
}

function openModalSubject() {
  localSubject.Descricao = "";
  localSubject.codAs = null;
  showModal.value = true;
}

function editSubject(subject) {
  localSubject.Descricao = subject.Descricao;
  localSubject.codAs = subject.codAs;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
}

async function saveSubject() {
  if (!localSubject.Descricao) return;
  saving.value = true;
  try {
    if (localSubject.codAs) {
      await updateSubject(localSubject.codAs, { name: localSubject.Descricao });
      Notify.create({ type: "positive", message: "Assunto atualizado com sucesso!" });
    } else {
      await createSubject({ name: localSubject.Descricao });
      Notify.create({ type: "positive", message: "Assunto criado com sucesso!" });
    }
    fetchSubjects();
    closeModal();
  } catch (error) {
    console.error(error);
    Notify.create({ type: "negative", message: "Erro ao salvar assunto" });
  } finally {
    saving.value = false;
  }
}

function deleteSubject(subject) {
  Dialog.create({
    title: "Confirmar",
    message: `Deseja realmente excluir o assunto "${subject.Descricao}"?`,
    cancel: true,
    persistent: true
  }).onOk(async () => {
    deleting.value = true;
    try {
      await apiDeleteSubject(subject.codAs);
      Notify.create({ type: "positive", message: "Assunto excluído" });
      fetchSubjects();
    } catch (error) {
      console.error(error);
      Notify.create({ type: "negative", message: "Erro ao deletar assunto" });
    } finally {
      deleting.value = false;
    }
  });
}

onMounted(() => {
  fetchSubjects();
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
