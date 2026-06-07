<script setup>
const props = defineProps({
  producto: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['agregar-carrito'])
</script>

<template>
  <div class="producto-card">
    <h3>{{ producto.nombre }}</h3>
    <p class="precio">${{ producto.precio }}</p>
    <p class="stock">Stock: {{ producto.stock }}</p>
    <p v-if="producto.descripcion" class="descripcion">
      {{ producto.descripcion }}
    </p>
    <button
      data-test="btn-agregar"
      @click="emit('agregar-carrito', producto)"
    >
      Agregar al carrito
    </button>
  </div>
</template>

<style scoped>
.producto-card {
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 16px;
  background: white;
}

.precio {
  font-weight: bold;
  color: #4f46e5;
  font-size: 1.2rem;
}

.stock {
  color: #6b7280;
  font-size: 0.9rem;
}

button {
  margin-top: 10px;
  padding: 8px 14px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
</style>