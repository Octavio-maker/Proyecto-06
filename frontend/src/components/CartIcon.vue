<template>
  <router-link to="/carrito" style="position: relative; text-decoration: none; font-size: 22px;">
    🛒
    <span v-if="carrito.totalItems > 0" class="badge">
      {{ carrito.totalItems }}
    </span>
  </router-link>
</template>

<script setup>
import { useCarritoStore } from '../stores/carrito'
const carrito = useCarritoStore()
</script>

<style scoped>
.badge {
  position: absolute;
  top: -8px;
  right: -10px;
  background: #e74c3c;
  color: white;
  font-size: 11px;
  font-weight: bold;
  padding: 3px 7px;
  border-radius: 50%;
  font-family: Arial, sans-serif;
}
</style>