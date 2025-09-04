<template>
  <div>
    <q-input
      v-model="subject.Descricao"
      label="Nome do Assunto"
      outlined
      dense
      autofocus
      :rules="[val => !!val || 'Nome é obrigatório']"
    />
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  subject: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["update:subject"]);

const subject = computed({
  get: () => props.subject,
  set: (val) => emit("update:subject", val),
});
</script>
