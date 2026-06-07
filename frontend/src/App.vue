<template>
  <nav style="background: #2c3e50; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif;">
    <div>
      <router-link to="/" style="color: white; text-decoration: none; font-weight: bold; margin-right: 20px;">🏠 Inicio</router-link>
      <router-link to="/catalogo" style="color: white; text-decoration: none; font-weight: bold;">📦 Catálogo</router-link>
    </div>
    <CartIcon />
  </nav>

  <router-view />
</template>

<script setup>
import CartIcon from './components/CartIcon.vue'
</script>