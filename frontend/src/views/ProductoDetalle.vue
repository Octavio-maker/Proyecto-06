<template>
  <div class="container mt-4" style="max-width: 600px;">
    <button @click="volver" class="btn btn-secondary mb-4">
      ← Volver al catálogo
    </button>
    
    <div v-if="producto" class="card p-4">
      <img 
        :src="producto.imagen_url" 
        class="card-img-top mb-3" 
        style="max-height: 300px; object-fit: contain; width: 100%;"
        @error="(e) => e.target.style.display = 'none'"
        alt="Imagen del producto"
      />

      <h2 style="color: #2c3e50;">{{ producto.nombre }}</h2>
      <hr>
      <p><strong>Descripción:</strong> {{ producto.descripcion || 'Sin descripción' }}</p>
      <p style="font-size: 1.2rem;"><strong>Precio:</strong> <span style="color:#2ecc71; font-weight:bold;">${{ producto.precio }}</span></p>
      <p><strong>Stock:</strong> {{ producto.stock }} unidades disponibles</p>
      
      <button @click="agregarAlCarrito" class="btn btn-success w-100 mt-3">
        Agregar al carrito
      </button>
    </div>

    <div v-else class="text-center mt-5 text-muted">
      Cargando ficha del producto...
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../plugins/axios'
// Importamos tu store del carrito
import { useCarritoStore } from '../stores/carrito'

const props = defineProps({
  id: { type: [String, Number], required: true }
})

const router = useRouter()
const carritoStore = useCarritoStore()
const producto = ref(null)

const volver = () => {
  router.back()
}

// Nueva función para agregar al carrito
const agregarAlCarrito = () => {
  carritoStore.agregar(producto.value)
  alert(`${producto.value.nombre} agregado al carrito`)
}

onMounted(async () => {
  try {
    const res = await api.get(`/productos/${props.id}`)
    producto.value = res.data.data ?? res.data
  } catch (err) {
    console.error("Error al cargar el producto:", err)
    alert("No se pudo cargar el producto.")
    router.back()
  }
})
</script>