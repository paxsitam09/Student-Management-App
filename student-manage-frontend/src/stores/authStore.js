import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isLoggedIn: !!sessionStorage.getItem('access_token'), // Check if a token exists at startup
  }),
  getters: {
    accessToken: (state) => sessionStorage.getItem('access_token')
  },
  actions: {
    login(accessToken) {
      sessionStorage.setItem('access_token', accessToken)
      this.isLoggedIn = true
    },
    logout() {
      // Remove token from localStorage and set the logged-in state to false
      sessionStorage.removeItem('access_token')
      this.isLoggedIn = false
    },
    checkAuthStatus() {
      // Check if token is present to determine logged-in state
      this.isLoggedIn = !!sessionStorage.getItem('access_token')
    }
  }
})
