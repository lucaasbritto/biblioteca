<template>
  <q-dialog v-model="dialogOpen" persistent>
    <q-card class="q-pa-md" style="min-width: 500px; max-width: 600px;">
      <q-card-section class="q-pt-none">
        <div class="text-h6 q-mb-md">{{ modalTitle }} X</div>

        <BookForm
          v-model:book="localBook"
          :autor-options="autorOptions"
          :assunto-options="assuntoOptions"
          ref="formRef"
        />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="grey" @click="close" />
        <q-btn
          color="primary"
          :label="actionLabel"
          :disable="!formRef?.isValid"
          :loading="loading"
          @click="save"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import BookForm from "./BookForm.vue";

const props = defineProps({
  modelValue: Boolean,
  book: Object,
  autorOptions: Array,
  assuntoOptions: Array
});

const emit = defineEmits(["update:modelValue", "save"]);

const dialogOpen = ref(props.modelValue);
const loading = ref(false);
const formRef = ref(null);


const localBook = ref({});

watch(
  () => props.book,
  (book) => {
    localBook.value = book
      ? {
          Codl: book.Codl,
          Titulo: book.Titulo || "",
          Editora: book.Editora || "",
          Edicao: book.Edicao || 1,
          AnoPublicacao: book.AnoPublicacao || "",
          autor: book.authors?.map((a) => a.CodAu) || [],
          assunto: book.subjects?.map((s) => s.codAs) || []
        }
      : {
          Titulo: "",
          Editora: "",
          Edicao: 1,
          AnoPublicacao: "",
          autor: [],
          assunto: []
        };
  },
  { immediate: true }
);

const modalTitle = computed(() =>
  props.book?.Codl ? "Edição de Livro" : "Cadastro de Livro"
);
const actionLabel = computed(() =>
  props.book?.Codl ? "Editar" : "Salvar"
);

watch(
  () => props.modelValue,
  (val) => (dialogOpen.value = val)
);
watch(dialogOpen, (val) => emit("update:modelValue", val));

function close() {
  dialogOpen.value = false;
}

async function save() {
  loading.value = true;
  const payload = {
    ...localBook.value,
    Codl: props.book?.Codl || null
  };
  emit("save", payload, () => {
    loading.value = false;
    close();
  });
}
</script>
