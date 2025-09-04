<template>
  <q-page class="flex flex-center bg-grey-2">
    <div class="full-width" style="max-width: 500px">
      <div class="text-h5 text-primary text-weight-bold q-mb-lg">
        Novo Autor
      </div>

      <q-card class="q-pa-lg shadow-3 rounded-borders">
        <q-form ref="formRef" @submit.prevent="save">
          <q-card-section>
            <AuthorForm v-model:author="localAuthor" ref="formRef" />
          </q-card-section>

          <q-separator class="q-my-md" />

          <q-card-actions align="right" class="q-gutter-sm">
            <q-btn outline color="grey-8" label="Cancelar" @click="goBack" type="button" />
            <q-btn unelevated color="primary" label="Salvar" :loading="loading" @click="save" type="button" />
          </q-card-actions>
        </q-form>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import AuthorForm from "../../components/Author/AuthorForm.vue";
import { createAuthor } from "../../api/requests";

const router = useRouter();
const loading = ref(false);
const formRef = ref(null);

const localAuthor = ref({ name: "" });

function goBack() {
  router.back();
}

async function save() {
  const valid = await formRef.value.validate();
  if (!valid) return;

  loading.value = true;

  try {
    await createAuthor(localAuthor.value);
    loading.value = false;
    router.push({ name: "AuthorList" });
  } catch (error) {
    console.error("Erro ao salvar autor:", error.response?.data || error);
    loading.value = false;
  }
}
</script>

<style scoped>
.rounded-borders {
  border-radius: 12px;
}
</style>
