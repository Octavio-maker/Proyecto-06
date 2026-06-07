<template>
  <div style="font-family: Arial, sans-serif; padding: 30px; max-width: 800px; margin: 0 auto;">
    <h2>🛒 Tu Carrito de Compras</h2>

    <div v-if="carrito.items.length === 0" style="text-align: center; padding: 40px; color: #7f8c8d;">
      <p style="font-size: 18px;">Tu carrito está vacío.</p>
      <router-link to="/catalogo" style="color:#3498db; text-decoration: none; font-weight: bold;">Ir a buscar productos →</router-link>
    </div>

    <div v-else>
      <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
        <thead>
          <tr style="border-bottom: 2px solid #ddd; text-align: left; background: #f4f6f7;">
            <th style="padding: 10px;">Producto</th>
            <th style="padding: 10px;">Precio</th>
            <th style="padding: 10px; text-align: center;">Cantidad</th>
            <th style="padding: 10px; text-align: right;">Subtotal</th>
            <th style="padding: 10px; text-align: center;">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in carrito.items" :key="item.id" style="border-bottom: 1px solid #eee;">
            <td style="padding: 12px;"><strong>{{ item.nombre }}</strong></td>
            <td style="padding: 12px;">${{ item.precio }}</td>
            <td style="padding: 12px; text-align: center;">
              <button @click="carrito.cambiarCantidad(item.id, item.cantidad - 1)" style="padding: 2px 8px; cursor:pointer;">-</button>
              <span style="margin: 0 12px; font-weight: bold;">{{ item.cantidad }}</span>
              <button @click="carrito.cambiarCantidad(item.id, item.cantidad + 1)" style="padding: 2px 8px; cursor:pointer;">+</button>
            </td>
            <td style="padding: 12px; text-align: right; font-weight: bold;">
              ${{ item.precio * item.cantidad }}
            </td>
            <td style="padding: 12px; text-align: center;">
              <button @click="carrito.quitar(item.id)" style="background: #e74c3c; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;">×</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #2c3e50; padding-top: 15px;">
        <button @click="confirmarVaciar" style="background: #7f8c8d; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">
          🗑️ Vaciar Carrito
        </button>
        <div style="text-align: right;">
          <h3 style="margin: 0;">Total General: <span style="color: #2ecc71;">${{ carrito.totalPrecio }}</span></h3>
          <button @click="finalizarCompra" style="margin-top: 10px; background: #2ecc71; color: white; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold;">
            ✅ Finalizar Compra
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCarritoStore } from '../stores/carrito'
const carrito = useCarritoStore()

const confirmarVaciar = () => {
  if (confirm('¿Seguro que deseas remover todos los artículos del carrito?')) {
    carrito.vaciar()
  }
}

const finalizarCompra = () => {
  alert('🎉 ¡Simulación de compra exitosa! Su orden está en proceso.')
  carrito.vaciar()
}
</script>