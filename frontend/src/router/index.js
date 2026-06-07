import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'inicio',
    component: () => import('@/views/HomeView.vue') 
  },
  {
    path: '/catalogo',
    name: 'catalogo',
    component: () => import('@/views/CatalogoView.vue')
  },
  {
    path: '/catalogo/:id', 
    name: 'producto-detalles',
    component: () => import('@/views/ProductoDetalle.vue'),
    props: true 
  },
  // RUTA DEL CARRITO AGREGADA
  {
    path: '/carrito',
    name: 'carrito',
    component: () => import('@/views/CartView.vue')
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/LoginView.vue')
  },
  {
    path: '/admin/crear',
    name: 'admin-crear',
    component: () => import('@/views/CrearProducto.vue'),
    meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from) => {
  const token = localStorage.getItem('token') 

  if (to.meta.requiresAuth && !token) {
    return { name: 'login' }
  }
})

export default router