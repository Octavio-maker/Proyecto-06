<template>
  <div class="container mt-4">
    <h2>🛒 Catálogo Completo</h2>

    <div class="mb-3">
      <button class="btn btn-outline-primary me-2" @click="cargarDatos">Todos</button>
      <button
        v-for="cat in categorias"
        :key="cat.id"
        class="btn btn-outline-primary me-2"
        @click="filtrarPorCategoria(cat)"
      >
        {{ cat.nombre }}
      </button>
    </div>

    <div class="row">
      <div v-if="productos.length === 0" class="col-12 text-center mt-5">
        <p>No se encontraron productos para mostrar.</p>
      </div>

      <div v-else v-for="producto in productos" :key="producto.id" class="col-md-3 mb-4">
        <div class="card h-100">
          <img 
            :src="producto.imagen_url" 
            class="card-img-top" 
            style="height:200px; object-fit:cover; width: 100%; background-color: #f0f0f0;"
            @error="handleImageError"
          />
          <div class="card-body">
            <h5 class="card-title">{{ producto.nombre }}</h5>
            <p class="fw-bold">${{ producto.precio }}</p>
            <router-link 
              :to="{ name: 'producto-detalles', params: { id: producto.id } }" 
              class="btn btn-primary w-100"
            >
              Ver detalles
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/plugins/axios' 

const categorias = ref([])
const productos = ref([])

// Función optimizada para ocultar imágenes que no cargan
const handleImageError = (event) => {
  event.target.style.display = 'none'; 
}

const cargarDatos = async () => {
  try {
    const [resCat, resProd] = await Promise.all([
      api.get('/categorias'),
      api.get('/productos')
    ]);
    categorias.value = resCat.data.data ?? resCat.data
    productos.value = Array.isArray(resProd.data) ? resProd.data : (resProd.data.data ?? [])
  } catch (e) {
    console.error("Error al cargar:", e)
  }
}

const filtrarPorCategoria = async (cat) => {
  try {
    const res = await api.get(`/categorias/${cat.id}/productos`)
    productos.value = Array.isArray(res.data) ? res.data : (res.data.data ?? [])
  } catch (e) {
    console.error("Error al filtrar:", e)
  }
}

onMounted(() => {
  cargarDatos()
})
</script>