<template>
    <nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Brand -->
          <div class="flex-shrink-0">
            <RouterLink to="/" class="text-white font-bold text-xl hover:text-pink-200 transition-colors">
              Student Management App
            </RouterLink>
          </div>

          <!-- Navigation Links -->
          <div class="hidden sm:flex sm:items-center sm:space-x-4">
            <RouterLink 
              v-if="!authStore.isLoggedIn"
              to="/" 
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Home
            </RouterLink>

            <RouterLink 
              v-if="authStore.isLoggedIn"
              to="/dashboard" 
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Dashboard
            </RouterLink>

            <RouterLink 
              v-if="!authStore.isLoggedIn" 
              to="/login"
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Login
            </RouterLink>

            <RouterLink 
              v-if="!authStore.isLoggedIn" 
              to="/register"
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Register
            </RouterLink>

            <RouterLink 
              v-if="authStore.isLoggedIn" 
              to="/students"
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Student List
            </RouterLink>

            <RouterLink 
              v-if="authStore.isLoggedIn" 
              to="/me"
              class="text-gray-100 hover:text-white hover:bg-white/10 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              active-class="bg-white/20"
            >
              Profile
            </RouterLink>


            <button 
              v-if="authStore.isLoggedIn" 
              @click="logout"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors shadow-md hover:shadow-lg"
            >
              Logout
            </button>
          </div>

          <!-- Mobile menu button -->
          <div class="sm:hidden">
            <button 
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-100 hover:text-white hover:bg-white/10 transition-colors"
            >
              <span class="sr-only">Open main menu</span>
              <!-- Heroicon name: menu -->
              <svg 
                class="h-6 w-6" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div 
        v-show="mobileMenuOpen" 
        class="sm:hidden bg-gradient-to-r from-indigo-700 via-purple-700 to-pink-700"
      >
        <div class="px-2 pt-2 pb-3 space-y-1">
          <RouterLink 
            v-if="!authStore.isLoggedIn"
            to="/" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Home
          </RouterLink>

          <RouterLink 
            v-if="authStore.isLoggedIn"
            to="/dashboard" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Dashboard
          </RouterLink>

          <RouterLink 
            v-if="!authStore.isLoggedIn"
            to="/login" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Login
          </RouterLink>

          <RouterLink 
            v-if="!authStore.isLoggedIn"
            to="/register" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Register
          </RouterLink>

          <RouterLink 
            v-if="authStore.isLoggedIn"
            to="/students" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Student List
          </RouterLink>

          <RouterLink 
            v-if="authStore.isLoggedIn"
            to="/me" 
            class="text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
            active-class="bg-white/20"
            @click="mobileMenuOpen = false"
          >
            Profile
          </RouterLink>

          <button 
            v-if="authStore.isLoggedIn"
            @click="logout(); mobileMenuOpen = false"
            class="w-full text-left text-gray-100 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-red-500"
          >
            Logout
          </button>
        </div>
      </div>
    </nav>
</template>
  
<script setup>
import axios from '@/axios'; // Import axios for logout
import router from '@/router';
import { ref } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useUserStore } from '@/stores/userStore';
import { useNotificationStore } from '@/stores/notificationStore';

const mobileMenuOpen = ref(false);
const authStore = useAuthStore();
const userStore = useUserStore();
const notificationStore = useNotificationStore();

// Logout function
const logout = async () => {
  try {
    await axios.post('/logout', {}, {
      withCredentials: true,
    })
    authStore.logout()
    userStore.clearUser()
    router.push('/login')
    notificationStore.success('Logout successful!');
  } catch (error) {
    console.error('Logout failed:', error);
    notificationStore.error('Logout failed. Please try again.');
  }
};
</script>