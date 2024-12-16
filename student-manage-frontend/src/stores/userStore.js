import { defineStore } from 'pinia'
import axios from '@/axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    role: null,
    isLoading: false,
    error: null
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
    userName: (state) => state.user?.name,
    userEmail: (state) => state.user?.email,
    userEmailVerified: (state) => state.user?.email_verified_at,
    userCreatedAt: (state) => state.user?.created_at,
    userUpdatedAt: (state) => state.user?.updated_at,
    userRole: (state) => state.role 
  },

  actions: {
    async fetchUserData() {
      this.isLoading = true
      try {
        const response = await axios.get('/me')
        this.user = response.data.user
        this.role = response.data.user.roles.length > 0 ? response.data.user.roles[0].name : null
        this.error = null
      } catch (error) {
        this.error = error.response?.data?.message || 'Error fetching user data'
        console.error('Error fetching user data:', error)
      } finally {
        this.isLoading = false
      }
    },

    clearUser() {
      this.user = null
      this.role = null
      this.error = null
    }
  }
})
