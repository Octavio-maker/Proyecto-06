<template>
  <div style="display: flex; font-family: Arial, sans-serif; min-height: 100vh;">
    <div style="width: 240px; background: #2c3e50; color: white; padding: 20px; box-sizing: border-box;">
      <h3>🛠️ Panel Admin</h3>
      <p style="font-size:13px; color:#1abc9c;">👤 Admin: <strong>{{ auth.user?.name }}</strong></p>
      <hr style="border:0; height:1px; background:#34495e; margin:15px 0;">
      <ul style="padding:0; list-style:none;">
        <li style="margin-bottom: 15px;"><router-link to="/admin" style="color:white; text-decoration:none;">📈 Dashboard</router-link></li>
        <li style="margin-bottom: 15px;"><router-link to="/admin/productos" style="color:white; text-decoration:none;">📦 Inventario</router-link></li>
        <li style="margin-top: 50px;"><router-link to="/" style="color:#e74c3c; text-decoration:none;">🏠 Salir al Home</router-link></li>
      </ul>
    </div>
    <div style="flex: 1; padding: 30px; background: #f8f9fa;">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
const auth = useAuthStore()
</script>
