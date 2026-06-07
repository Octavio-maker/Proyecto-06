<template>
  <div class="card p-3 mb-4">
    <h5>Filtros</h5>
    
    <div class="mb-3">
      <label>Buscar</label>
      <input 
        type="text" 
        class="form-control" 
        v-model="filtros.busqueda" 
        placeholder="Nombre o descripción..."
      >
    </div>

    <div class="row">
      <div class="col-6">
        <label>Precio Mín</label>
        <input type="number" class="form-control" v-model="filtros.precio_min">
      </div>
      <div class="col-6">
        <label>Precio Máx</label>
        <input type="number" class="form-control" v-model="filtros.precio_max">
      </div>
    </div>

    <button class="btn btn-secondary mt-3 w-100" @click="limpiarFiltros">
      Limpiar filtros
    </button>
  </div>
</template>

<script setup>
import { useFiltros } from '@/composables/useFiltros'

const { filtros } = useFiltros()

const limpiarFiltros = () => {
  filtros.busqueda = ''
  filtros.categoria_id = ''
  filtros.precio_min = ''
  filtros.precio_max = ''
  filtros.pagina = 1
}
</script>