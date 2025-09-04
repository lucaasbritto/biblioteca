<template>
  <div class="q-gutter-md">
    <q-input
      v-model="book.Titulo"
      label="Título"
      outlined dense autofocus
      :rules="[val => !!val || 'Título obrigatório']"
    />

    <div class="row q-mt-sm">
      <div class="col-6">
        <q-select
          v-model="book.autor"
          :options="autorOptions"
          label="Autor"
          outlined dense
          emit-value map-options
          multiple
          :rules="[val => !!val?.length || 'Selecione um autor']"
        />
      </div>
      <div class="col-6">
        <q-select
          v-model="book.assunto"
          :options="assuntoOptions"
          label="Assunto"
          outlined dense
          emit-value map-options
          multiple
          :rules="[val => !!val?.length || 'Selecione um assunto']"
        />
      </div>
    </div>

    <div class="row q-mt-sm">
      <div class="col-4">
        <q-input 
        v-model="book.Editora" 
        label="Editora" 
        outlined dense 
        :rules="[val => !!val || 'Editora obrigatória']"
        />
      </div>
      <div class="col-4">
        <q-input
          v-model.number="book.Edicao"
          label="Edição"
          outlined dense type="number"
          :rules="[val => val >= 1 || 'Edição deve ser ≥ 1']"
        />
      </div>
      <div class="col-4">
        <q-input
          v-model="book.AnoPublicacao"
          label="Ano"
          outlined dense type="number" maxlength="4"
          :rules="[val => val && val.toString().length === 4 || 'Ano deve ter 4 dígitos']"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  book: { type: Object, required: true },
  autorOptions: Array,
  assuntoOptions: Array
});

const isValid = computed(() =>
  !!props.book.Titulo &&
  !!props.book.autor?.length &&
  !!props.book.assunto?.length &&
  !!props.book.Editora &&
  !!props.book.AnoPublicacao &&
  props.book.AnoPublicacao.toString().length === 4 &&
  props.book.Edicao >= 1
);

defineExpose({ isValid });
</script>
