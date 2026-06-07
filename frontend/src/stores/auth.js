import { defineStore } from 'pinia'
import api from '../plugins/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    loading: false
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async login(credentials) {
      this.loading = true
      try {
        const response = await api.post('/login', credentials)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        return { success: true }
      } catch (error) {
        return { success: false, message: 'Credenciales inválidas.' }
      } finally {
        this.loading = false
      }
    },
    async fetchUser() {
      try {
        const response = await api.get('/me')
        this.user = response.data
      } catch (error) {
        this.logout()
      }
    },
    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
    }
  }
})