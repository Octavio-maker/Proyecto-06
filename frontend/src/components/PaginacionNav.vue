<template>
  <nav v-if="meta.last_page > 1" class="mt-4">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <button class="page-link" @click="$emit('cambio-pagina', meta.current_page - 1)">Anterior</button>
      </li>

      <li class="page-item active">
        <span class="page-link">{{ meta.current_page }} / {{ meta.last_page }}</span>
      </li>

      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <button class="page-link" @click="$emit('cambio-pagina', meta.current_page + 1)">Siguiente</button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
defineProps({
  meta: {
    type: Object,
    required: true
  }
})

defineEmits(['cambio-pagina'])
</script>