<template>
  <div style="font-family: Arial, sans-serif; padding: 25px; max-width: 500px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 30px;">
    <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">➕ Registrar Producto con Imagen</h2>
    
    <div v-if="errorValidacion" style="background:#e74c3c; color:white; padding:12px; margin-bottom:20px; border-radius:4px; font-weight: bold; text-align: center;">
      {{ errorValidacion }}
    </div>

    <div v-if="mensaje" style="background:#2ecc71; color:white; padding:12px; margin-bottom:20px; border-radius:4px; font-weight: bold; text-align: center;">
      {{ mensaje }}
    </div>
    
    <form @submit.prevent="guardar">
      <div style="margin-bottom: 15px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Nombre del Producto *</label>
        <input v-model="form.nombre" type="text" placeholder="Ej. iPhone 17 Pro Max" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;" required>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Descripción *</label>
        <textarea v-model="form.descripcion" placeholder="Especificaciones técnicas del artículo..." style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; height: 80px; resize: none;" required></textarea>
      </div>

      <div style="display: flex; gap: 15px; margin-bottom: 15px;">
        <div style="flex: 1;">
          <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Precio ($) *</label>
          <input v-model.number="form.precio" type="number" step="0.01" placeholder="0.00" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>
        <div style="flex: 1;">
          <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Stock Inicial *</label>
          <input v-model.number="form.stock" type="number" placeholder="0" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>
      </div>
      
      <div style="margin-bottom: 15px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Imagen de Portada *</label>
        <input type="file" accept="image/*" @change="onImageChange" style="display: block; margin-top: 5px;">
      </div>

      <div v-if="preview" style="margin-bottom:20px; text-align: center; border: 1px dashed #cbd5e1; padding: 10px; background: #f8fafc; border-radius: 4px;">
        <p style="margin: 0 0 10px 0; font-size: 13px; color: #64748b;">Vista previa del archivo:</p>
        <img :src="preview" alt="Preview" style="max-width:100%; max-height:160px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      </div>

      <!-- Selector de categoría -->
      <div style="margin-bottom: 15px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Categoría</label>
        <select v-model="form.categoria_id" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
          <option value="">Sin categoría</option>
          <option
            v-for="cat in categorias"
            :key="cat.id"
            :value="cat.id"
          >
            {{ cat.nombre }}
          </option>
        </select>
      </div>

      <button type="submit" :disabled="cargando" style="background:#3498db; color:white; border:none; padding:12px; width:100%; cursor:pointer; font-weight: bold; border-radius: 4px; font-size: 15px;">
        {{ cargando ? '🚀 Subiendo archivos a Laravel...' : '💾 Guardar Producto' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import api from '../plugins/axios'

const form = reactive({ 
  nombre: '', 
  descripcion: '', 
  precio: '', 
  stock: '',
  categoria_id: ''
})

const categorias = ref([])
const imagen = ref(null)
const preview = ref(null)
const cargando = ref(false)
const mensaje = ref('')
const errorValidacion = ref('')

// Carga las categorías al montar el componente
onMounted(async () => {
  const { data } = await api.get('/categorias')
  categorias.value = data.data
})

const onImageChange = (e) => {
  const file = e.target.files[0]
  if (!file) return
  
  if (file.size > 2 * 1024 * 1024) {
    errorValidacion.value = '⚠️ La imagen seleccionada es demasiado grande. El límite es de 2MB.'
    e.target.value = ''
    setTimeout(() => { errorValidacion.value = '' }, 4000)
    return
  }

  imagen.value = file
  preview.value = URL.createObjectURL(file)
}

const guardar = async () => {
  if (form.precio <= 0) {
    errorValidacion.value = '❌ Error de validación: El precio del artículo debe ser mayor a $0.00.'
    setTimeout(() => { errorValidacion.value = '' }, 4000)
    return
  }

  if (form.stock < 0) {
    errorValidacion.value = '❌ Error de validación: El stock inicial no puede ser un número negativo.'
    setTimeout(() => { errorValidacion.value = '' }, 4000)
    return
  }

  errorValidacion.value = ''
  cargando.value = true
  
  const fd = new FormData()
  fd.append('nombre', form.nombre)
  fd.append('descripcion', form.descripcion)
  fd.append('precio', form.precio)
  fd.append('stock', form.stock)
  fd.append('categoria_id', form.categoria_id)
  
  if (imagen.value) {
    fd.append('imagen', imagen.value)
  }

  try {
    await api.post('/productos', fd, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    
    mensaje.value = '¡Producto creado con éxito en Laravel!'
    
    form.nombre = ''
    form.descripcion = ''
    form.precio = ''
    form.stock = ''
    form.categoria_id = ''
    imagen.value = null
    preview.value = null
    
    setTimeout(() => { mensaje.value = '' }, 3000)

  } catch (err) {
    console.error("Error en el envío multimedia:", err)
    alert('Hubo un problema al subir el archivo binario al servidor.')
  } finally {
    cargando.value = false
  }
}
</script>