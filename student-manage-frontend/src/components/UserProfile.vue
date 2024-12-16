<template>
  <div class="min-h-screen flex items-center justify-center">
    <!-- Profile Card -->
    <div class="bg-white/90 backdrop-blur-lg rounded-2xl p-8 w-full max-w-md shadow-xl hover:-translate-y-1 transition-transform duration-300">
      <!-- Avatar Section -->
      <div class="flex justify-center mb-6">
        <div class="relative">
          <div class="w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-2xl font-bold text-white border-4 border-white shadow-lg">
            {{ userInitials }}
          </div>
          <!-- Status Dot -->
          <div class="absolute bottom-1 right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white animate-pulse"></div>
        </div>
      </div>

      <!-- User Info -->
      <div class="text-center">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ userStore.userName }}</h2>
        <p class="text-gray-500 text-sm mb-6">{{ userStore.userEmail }}</p>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50/80 rounded-xl mb-6">
          <div class="flex flex-col items-center">
            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Member since</span>
            <span class="text-sm font-medium text-gray-700">{{ formatDate(userStore.user?.created_at) }}</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Role</span>
            <span class="text-sm font-medium text-gray-700">
              {{ userStore.role }}
            </span>
          </div>
        </div>

        <!-- Logout Button -->
        <button 
          @click="handleLogout"
          class="w-full py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-medium 
                 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 
                 active:translate-y-0 active:shadow-md"
        >
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue'
import { useUserStore } from '@/stores/userStore'
import { useRouter } from 'vue-router'
import axios from '@/axios'
import { useAuthStore } from '@/stores/authStore'
import { useNotificationStore } from '@/stores/notificationStore'
export default {
  setup() {
    const userStore = useUserStore()
    const router = useRouter()
    const userInitials = computed(() => {
      if (!userStore.userName) return ''
      return userStore.userName
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
    })

    const formatDate = (dateString) => {
      if (!dateString) return ''
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }

    const handleLogout = async () => {
      try {
        await axios.post('/logout', {}, {
          withCredentials: true,
        })
        userStore.clearUser()
        useAuthStore().logout()
        useNotificationStore().success('Logout Successfully')
        router.push('/login')
      } catch (error) {
        console.error('Logout error:', error)
      }
    }

    onMounted(() => {
      userStore.fetchUserData()
    })

    return {
      userStore,
      userInitials,
      handleLogout,
      formatDate
    }
  }
}
</script>