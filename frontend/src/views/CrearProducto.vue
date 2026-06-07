<script setup>
import { ref } from 'vue'
import { useForm, useField } from 'vee-validate'
import { productoSchema } from '@/schemas/productoSchema'
import InputField from '@/components/InputField.vue'
import api from '@/plugins/axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const erroresServidor = ref({})
const exitoso = ref(false)
const imagenFile = ref(null)

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema: productoSchema,
  initialValues: {
    nombre: '',
    precio: '',
    stock: 0,
    descripcion: '',
    categoria_id: null,
  }
})

const { value: nombre }      = useField('nombre')
const { value: precio }      = useField('precio')
const { value: stock }       = useField('stock')
const { value: descripcion } = useField('descripcion')

function onImagenChange(e) {
  imagenFile.value = e.target.files[0] || null
}

const onSubmit = handleSubmit(async (values) => {
  erroresServidor.value = {}
  exitoso.value = false

  try {
    const formData = new FormData()
    formData.append('nombre', values.nombre)
    formData.append('precio', values.precio)
    formData.append('stock', values.stock)
    if (values.descripcion) formData.append('descripcion', values.descripcion)
    if (imagenFile.value)   formData.append('imagen', imagenFile.value)

    await api.post('/productos', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    resetForm()
    imagenFile.value = null
    exitoso.value = true

  } catch (e) {
    // Si el servidor responde con 422, guardamos los errores para mostrarlos en el template
    if (e.response?.status === 422) {
      erroresServidor.value = e.response.data.errors
    } else {
      // Quitamos el alert() para evitar que bloquee la interfaz
      console.error('Error al guardar el producto:', e)
    }
  }
})
</script>

<template>
  <div class="crear-producto">
    <h1>Crear Producto</h1>

    <div v-if="exitoso" class="alerta-exito">
      ✅ Producto creado exitosamente.
    </div>

    <form @submit.prevent="onSubmit" novalidate>

      <InputField
        label="Nombre del producto"
        name="nombre"
        v-model="nombre"
        placeholder="Ej: Camiseta azul"
        :error="errors.nombre || erroresServidor.nombre?.[0]"
      />

      <InputField
        label="Precio"
        name="precio"
        type="number"
        v-model="precio"
        placeholder="Ej: 299.99"
        :error="errors.precio || erroresServidor.precio?.[0]"
      />

      <InputField
        label="Stock"
        name="stock"
        type="number"
        v-model="stock"
        placeholder="Ej: 10"
        :error="errors.stock || erroresServidor.stock?.[0]"
      />

      <InputField
        label="Descripción (opcional)"
        name="descripcion"
        v-model="descripcion"
        placeholder="Descripción breve del producto"
        :error="errors.descripcion || erroresServidor.descripcion?.[0]"
      />

      <div class="campo">
        <label for="imagen">Imagen (opcional)</label>
        <input id="imagen" type="file" accept=".jpg,.png,.webp" @change="onImagenChange" />
        <span class="error-msg" v-if="erroresServidor.imagen">
          {{ erroresServidor.imagen[0] }}
        </span>
      </div>

      <button type="submit" class="btn-guardar">Guardar producto</button>
    </form>
  </div>
</template>

<style scoped>
.crear-producto {
  max-width: 500px;
  margin: 40px auto;
  padding: 24px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.1);
}

h1 {
  margin-bottom: 24px;
  font-size: 1.5rem;
}

.alerta-exito {
  background: #dcfce7;
  color: #166534;
  padding: 10px 14px;
  border-radius: 6px;
  margin-bottom: 16px;
}

.btn-guardar {
  width: 100%;
  padding: 10px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-guardar:hover {
  background: #4338ca;
}

.campo {
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 16px;
}

label { font-weight: 600; font-size: 0.9rem; }

.error-msg { color: #ef4444; font-size: 0.8rem; }
</style>