<template>
  <div class="container mt-4">
    <h2>🛒 Catálogo Completo</h2>

    <FiltrosPanel />

    <div class="row">
      <div v-if="cargando" class="col-12 text-center my-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p>Cargando productos...</p>
      </div>

      <div v-else-if="productos.length === 0" class="col-12 text-center mt-5">
        <p>No se encontraron productos con los filtros seleccionados.</p>
      </div>

      <div v-else v-for="producto in productos" :key="producto.id" class="col-md-3 mb-4">
        <div class="card h-100">
          <img 
          :src="'http://127.0.0.1:8000/storage/' + producto.imagen" 
          class="card-img-top" 
         style="height:200px; object-fit:cover; width: 100%; background-color: #f0f0f0;"
         @error="handleImageError"
/>
          <div class="card-body">
            <h5 class="card-title">{{ producto.nombre }}</h5>
            <p class="fw-bold text-primary">${{ producto.precio }}</p>
            <router-link 
              :to="{ name: 'producto-detalles', params: { id: producto.id } }" 
              class="btn btn-outline-primary w-100"
            >
              Ver detalles
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <PaginacionNav 
      v-if="meta.last_page > 1"
      :meta="meta" 
      @cambio-pagina="filtros.pagina = $event" 
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/plugins/axios'
import { useFiltros } from '@/composables/useFiltros'
import PaginacionNav from '@/components/PaginacionNav.vue'
import FiltrosPanel from '@/components/FiltrosPanel.vue'

const route = useRoute()
const { filtros } = useFiltros()

const productos = ref([])
const meta = ref({})
const cargando = ref(false)

const cargarProductos = async () => {
  cargando.value = true
  try {
    const { data } = await api.get('/productos', {
      params: {
        busqueda:     filtros.busqueda,
        categoria:    filtros.categoria_id, // Cambiado de categoria_id a categoria (como en useFiltros)
        min:          filtros.precio_min,   // Cambiado de precio_min a min
        max:          filtros.precio_max,   // Cambiado de precio_max a max
        page:         filtros.pagina,
      }
    })
    productos.value = data.data 
    meta.value = data.meta 
  } catch (e) {
    console.error("Error al cargar productos:", e)
  } finally {
    cargando.value = false
  }
}

watch(() => route.query, cargarProductos, { immediate: true })

// Esta función ocultará la imagen si falla al cargar
const handleImageError = (event) => { 
  event.target.style.display = 'none'; 
}
</script>