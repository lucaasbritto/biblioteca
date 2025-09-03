<template>
  <q-dialog v-model="dialogOpen" persistent>
    <q-card class="q-pa-md" style="min-width: 500px; max-width: 600px;">
      <q-card-section class="q-pt-none">
        <div class="text-h6 q-mb-md">{{ modalTitle }}</div>
        <div class="q-gutter-md">
        <q-input
            v-model="localBook.Titulo"
            label="Título"
            outlined dense autofocus
            :rules="[val => !!val || 'Título obrigatório']"
        />

        <div class="row q-mt-sm">
            <div class="col-6">
            <q-select
                v-model="localBook.autor"
                :options="autorOptions"
                label="Autor"
                outlined dense
                emit-value map-options
                multiple
                :rules="[val => !!val || 'Selecione um autor']"
            />
            </div>
            <div class="col-6">
            <q-select
                v-model="localBook.assunto"
                :options="assuntoOptions"
                label="Assunto"
                outlined dense
                emit-value map-options
                multiple
                :rules="[val => !!val || 'Selecione um assunto']"
            />
            </div>
        </div>

        <div class="row q-mt-sm">
            <div class="col-4">
            <q-input v-model="localBook.Editora" label="Editora" outlined dense />
            </div>
            <div class="col-4">
            <q-input
                v-model.number="localBook.Edicao"
                label="Edição"
                outlined dense type="number"
                :rules="[val => val >= 1 || 'Edição deve ser ≥ 1']"
            />
            </div>
            <div class="col-4">
            <q-input
                v-model="localBook.AnoPublicacao"
                label="Ano"
                outlined dense type="number" maxlength="4"
                :rules="[val => val && val.toString().length === 4 || 'Ano deve ter 4 dígitos']"
            />
            </div>
        </div>
        </div>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="grey" @click="close" />
        <q-btn
          color="primary"
          :label="actionLabel"
          :disable="!isValid"
          :loading="loading"
          @click="save"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { reactive, watch, ref, computed } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  book: Object,
  autorOptions: Array,
  assuntoOptions: Array
})

const emit = defineEmits(['update:modelValue', 'save'])

const dialogOpen = ref(props.modelValue)
const loading = ref(false)

const localBook = reactive({
  Titulo: '',
  Editora: '',
  Edicao: 1,
  AnoPublicacao: '',
  autor: [], 
  assunto: []
})

const isValid = computed(() =>
  !!localBook.Titulo &&
  !!localBook.autor &&
  !!localBook.assunto &&
  !!localBook.Editora &&
  !!localBook.AnoPublicacao &&
  localBook.AnoPublicacao.toString().length === 4 &&
  localBook.Edicao >= 1
)

const modalTitle = computed(() => props.book?.Codl ? 'Edição de Livro' : 'Cadastro de Livro')
const actionLabel = computed(() => props.book?.Codl ? 'Editar' : 'Salvar')

watch(() => props.book, book => {
  if (book) {
    localBook.Titulo = book.Titulo || ''
    localBook.Editora = book.Editora || ''
    localBook.Edicao = book.Edicao || 1
    localBook.AnoPublicacao = book.AnoPublicacao || ''
    localBook.autor = book.authors?.map(a => a.CodAu) || []
    localBook.assunto = book.subjects?.map(s => s.codAs) || []
    
  }
}, { immediate: true })

watch(() => props.modelValue, val => dialogOpen.value = val)
watch(dialogOpen, val => emit('update:modelValue', val))

function close() {
  dialogOpen.value = false
}

async function save() {
  loading.value = true
  const payload = {
    ...localBook,
    Codl: props.book?.Codl || null, 
    autor: localBook.autor,
    assunto: localBook.assunto
  }
  emit('save', payload, () => {
    loading.value = false
    close()
  })
}
</script>
