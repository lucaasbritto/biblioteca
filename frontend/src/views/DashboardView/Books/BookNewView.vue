<template>
  <q-page class="flex flex-center bg-grey-2">
    <div class="full-width" style="max-width: 800px">
      
      <div class="text-h5 text-primary text-weight-bold q-mb-lg">
        Cadastro de Livro
      </div>

      <q-card class="q-pa-lg shadow-3 rounded-borders">
        <q-form @submit.prevent="save" ref="formRef">
          <q-card-section>
            <BookForm
              v-model:book="localBook"
              :autor-options="autorOptions"
              :assunto-options="assuntoOptions"
            />
          </q-card-section>

          <q-separator class="q-my-md" />

          <q-card-actions align="right" class="q-gutter-sm">
            <q-btn
              outline
              color="grey-8"
              label="Cancelar"
              @click="goBack"
              type="button"
            />
            <q-btn
              unelevated
              color="primary"
              :loading="loading"
              label="Salvar"
              @click="save"
            />
          </q-card-actions>
        </q-form>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import BookForm from "../../../components/Books/BookForm.vue";
import { useFilterStore } from "../../../stores/filters";
import { createBook } from "../../../api/requests";

const router = useRouter();
const loading = ref(false);
const formRef = ref(null);

const localBook = ref({
  Titulo: "",
  Editora: "",
  Edicao: 1,
  AnoPublicacao: "",
  autor: [],
  assunto: []
});

const filterStore = useFilterStore();
const autorOptions = filterStore.autores;
const assuntoOptions = filterStore.assuntos;

function goBack() {
  router.back();
}

async function save() {
  const valid = await formRef.value.validate();
  if (!valid) return;

  loading.value = true;

  try {
    const payload = {
      ...localBook.value,
      Codl: null
    };

    await createBook(payload);

    loading.value = false;
    router.push({ name: "Dashboard" });
  } catch (error) {
    console.error("Erro ao salvar livro:", error.response?.data || error);
    loading.value = false;
  }
}
</script>

<style scoped>
.rounded-borders {
  border-radius: 12px;
}
</style>
