<script setup>
import { useAuthStore } from '@/stores/authStore';
import { useUserStore } from './stores/userStore';
import { useRouter } from 'vue-router';
import Navbar from './views/Layouts/Navbar.vue';
import Footer from './views/Layouts/Footer.vue';
import MainContent from './views/Layouts/MainContent.vue';

const authStore = useAuthStore();

// Check authentication status on app load
authStore.checkAuthStatus();
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Navbar with gradient -->
    <Navbar/>

    <!-- Main Content -->
    <MainContent/>

    <!-- Footer -->
    <Footer/>

  </div>
</template>