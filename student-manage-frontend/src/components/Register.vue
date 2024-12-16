<template>
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md transform transition-all hover:-translate-y-1 duration-300">
      <!-- Register Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-8 text-center">
          <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
          <p class="text-indigo-100">Join our community today</p>
        </div>

        <!-- Register Form -->
        <div class="p-6 sm:p-8">
          <form @submit.prevent="register" class="space-y-6">
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Full Name
              </label>
              <div class="relative">
                <input
                  id="name"
                  v-model="name"
                  type="text"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 backdrop-blur-sm"
                  placeholder="Enter your full name"
                />
              </div>
            </div>

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
              </div>
            </div>

            <!-- Role Field -->
            <div>
              <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                Select Role
              </label>
              <select
                id="role"
                v-model="role"
                required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 backdrop-blur-sm"
              >
                <option value="" disabled>Select your role</option>
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
              </select>
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
                  placeholder="Create a password"
                />
              </div>
            </div>

            <!-- Confirm Password Field -->
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm Password
              </label>
              <div class="relative">
                <input
                  id="password_confirmation"
                  v-model="password_confirmation"
                  type="password"
                  required
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white/50 backdrop-blur-sm"
                  placeholder="Confirm your password"
                />
              </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-center">
              <input
                type="checkbox"
                id="terms"
                required
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              />
              <label for="terms" class="ml-2 text-sm text-gray-600">
                I agree to the
                <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms</a>
                and
                <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
              </label>
            </div>

            <!-- Register Button -->
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
              {{ isLoading ? 'Creating account...' : 'Create Account' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '@/axios'
import { useNotificationStore } from '@/stores/notificationStore'

export default {
  setup() {
    const router = useRouter()
    const name = ref('')
    const email = ref('')
    const role = ref('') // Added role property
    const password = ref('')
    const password_confirmation = ref('')
    const isLoading = ref(false)

    const register = async () => {
      isLoading.value = true
      try {
        const response = await axios.post('/register', {
          name: name.value,
          email: email.value,
          role: role.value, // Include role in payload
          password: password.value,
          password_confirmation: password_confirmation.value
        })
        useNotificationStore().success('Account created successfully')
        await router.push('/dashboard')
      } catch (error) {
        useNotificationStore().error('Registration failed. Please try again.')
      } finally {
        isLoading.value = false
      }
    }

    return {
      name,
      email,
      role, // Added role to return object
      password,
      password_confirmation,
      isLoading,
      register
    }
  }
}
</script>
s