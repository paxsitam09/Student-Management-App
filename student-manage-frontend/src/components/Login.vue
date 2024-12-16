<template>
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md transform transition-all hover:-translate-y-1 duration-300">
      <!-- Login Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-8 text-center">
          <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
          <p class="text-indigo-100">Sign in to your account</p>
        </div>

        <!-- Login Form -->
        <div class="p-6 sm:p-8">
          <form @submit.prevent="login" class="space-y-6">
            <!-- Email Field -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
              </label>
              <div class="relative">
                <input
                  id="email"
                  v-model="email"
                  type="email"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 backdrop-blur-sm"
                  placeholder="Enter your email"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Password Field -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Password
              </label>
              <div class="relative">
                <input
                  id="password"
                  v-model="password"
                  type="password"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 backdrop-blur-sm"
                  placeholder="Enter your password"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
              <div class="flex items-center">
                <input
                  type="checkbox"
                  id="remember"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                />
                <label for="remember" class="ml-2 text-gray-600">Remember me</label>
              </div>
            </div>

            <!-- Login Button -->
            <button
              type="submit"
              :disabled="isLoading"
              class="w-full flex justify-center py-3 px-4 rounded-xl text-white font-medium
                     bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600
                     hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700
                     focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                     transform transition-all hover:-translate-y-0.5
                     disabled:opacity-50 disabled:cursor-not-allowed
                     shadow-lg hover:shadow-xl"
            >
              <svg
                v-if="isLoading"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isLoading ? 'Signing in...' : 'Sign in' }}
            </button>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-600">
              Don't have an account?
              <RouterLink to="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                Create one now
              </RouterLink>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import axios from '@/axios'
import { useNotificationStore } from '@/stores/notificationStore';

export default {
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const email = ref('')
    const password = ref('')
    const isLoading = ref(false)

    const login = async () => {
      isLoading.value = true
      try {
        const response = await axios.post('/login', {
          email: email.value,
          password: password.value
        })
        sessionStorage.setItem('access_token', response.data.access_token);
        authStore.login(response.data.access_token);
        useNotificationStore().success('Login Successful');
        router.push('/dashboard');
      } catch (error) {
          useNotificationStore().error('Incorrect Username Or Password. Please try again.');
      } finally {
        isLoading.value = false
      }
    }

    return {
      email,
      password,
      isLoading,
      login
    }
  }
}
</script>