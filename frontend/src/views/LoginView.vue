<template>
  <div style="font-family: Arial, sans-serif; padding: 25px; max-width: 400px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 50px;">
    <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">🔐 Iniciar Sesión</h2>
    
    <div v-if="errorMsg" style="background:#e74c3c; color:white; padding:12px; margin-bottom:20px; border-radius:4px; font-weight: bold; text-align: center;">
      {{ errorMsg }}
    </div>

    <form @submit.prevent="handleLogin">
      <div style="margin-bottom: 15px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Correo Electrónico:</label>
        <input v-model="email" type="email" placeholder="admin@tienda.com" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;" required>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display:block; font-weight:bold; margin-bottom: 5px; color: #34495e;">Contraseña:</label>
        <input v-model="password" type="password" placeholder="••••••••" style="width:100%; padding:10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;" required>
      </div>

      <button type="submit" :disabled="cargando" style="background:#2ecc71; color:white; border:none; padding:12px; width:100%; cursor:pointer; font-weight: bold; border-radius: 4px; font-size: 15px;">
        {{ cargando ? 'Verificando cuenta...' : 'Ingresar al Panel' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../plugins/axios'

const router = useRouter()
const email = ref('')
const password = ref('')
const cargando = ref(false)
const errorMsg = ref('')

const handleLogin = async () => {
  cargando.value = true
  errorMsg.value = ''
  
  try {
    // Enviamos un objeto JSON limpio y directo al endpoint de Laravel
    const res = await api.post('/login', {
      email: email.value,
      password: password.value
    })
    
    // Si el backend responde con éxito, guardamos el Token Sanctum en el navegador
    if (res.data.token) {
      localStorage.setItem('token', res.data.token)
      // Redirigimos de inmediato a la ruta protegida que creamos en el paso anterior
      router.push('/admin/crear')
    } else {
      errorMsg.value = 'Error en la respuesta del servidor.'
    }
  } catch (err) {
    console.error(err)
    // Atrapamos el error 401 o cualquier fallo de validación
    errorMsg.value = '❌ Las credenciales ingresadas no son válidas o el usuario no existe.'
  } finally {
    cargando.value = false
  }
}
</script>