<template>
  <div style="font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 30px; text-align: center;">
    <div style="background: #2c3e50; color: white; padding: 45px 20px; border-radius: 8px; margin-bottom: 35px;">
      <h1>🚀 Tienda Virtual SPA</h1>
      <p>Navegación instantánea multi-vista sin recargas de navegador.</p>
      <router-link to="/catalogo" style="display:inline-block; margin-top:12px; background:#e67e22; color:white; padding:10px 20px; text-decoration:none; border-radius:4px; font-weight:bold;">
        Explorar Catálogo
      </router-link>
    </div>

    <h3>✨ Productos Destacados</h3>
    <div style="display: flex; gap: 20px; justify-content: center; margin-top: 15px;">
      <div v-for="p in novedades" :key="p.id" style="border: 1px solid #ddd; padding: 15px; border-radius: 6px; width: 200px;">
        <h4>{{ p.nombre }}</h4>
        <p style="color: #27ae60; font-weight: bold;">${{ p.precio }}</p>
        <router-link :to="'/catalogo/' + p.id" style="color: #3498db; text-decoration: none; font-size: 14px;">Ver Detalles →</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../plugins/axios'

const novedades = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/productos')
    novedades.value = res.data.slice(0, 3)
  } catch (err) {
    console.error(err)
  }
})
</script>