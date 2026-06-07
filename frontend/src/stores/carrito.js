import { defineStore } from 'pinia'

export const useCarritoStore = defineStore('carrito', {
  state: () => ({
    // Carga inicial desde el localStorage para persistir los datos (Punto 4.1)
    items: JSON.parse(localStorage.getItem('carrito') || '[]')
  }),

  getters: {
    // Totales calculados de forma reactiva mediante getters de Pinia
    totalItems: (state) => state.items.reduce((s, i) => s + i.cantidad, 0),
    totalPrecio: (state) => state.items.reduce((s, i) => s + (i.precio * i.cantidad), 0),
    cantidadDeProducto: (state) => (id) => {
      return state.items.find(i => i.id === id)?.cantidad || 0
    }
  },

  actions: {
    // Incrementa la cantidad si ya existe, si no, lo registra (Punto 4.2)
    agregar(producto) {
      const existe = this.items.find(i => i.id === producto.id)
      if (existe) {
        existe.cantidad++
      } else {
        this.items.push({
          id: producto.id,
          nombre: producto.nombre,
          precio: producto.precio,
          cantidad: 1
        })
      }
      this.guardarLocalStorage()
    },

    quitar(id) {
      this.items = this.items.filter(i => i.id !== id)
      this.guardarLocalStorage()
    },

    // Controla los sumadores/restadores actualizando totales (Punto 4.2)
    cambiarCantidad(id, cantidad) {
      const producto = this.items.find(i => i.id === id)
      if (producto) {
        producto.cantidad = cantidad
        if (producto.cantidad <= 0) {
          this.quitar(id)
        }
      }
      this.guardarLocalStorage()
    },

    vaciar() {
      this.items = []
      this.guardarLocalStorage()
    },

    // Sincronización manual/automática con localStorage
    guardarLocalStorage() {
      localStorage.setItem('carrito', JSON.stringify(this.items))
    }
  }
})