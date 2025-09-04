<template>
  <div class="q-gutter-md">
    <q-input
      v-model="author.name"
      label="Nome do Autor"
      outlined
      dense
      autofocus
      :rules="[val => !!val || 'Nome obrigatório']"
    />
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  author: { type: Object, required: true }
});

const isValid = computed(() => !!props.author.name);
defineExpose({ isValid });
</script>
