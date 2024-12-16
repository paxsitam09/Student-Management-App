src/views/Dashboard.vue
<template>
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-6 text-white shadow-lg">
            <h1 class="text-2xl font-bold">Welcome back, {{ userStore.userName }}</h1>
            <p class="text-indigo-100 mt-2">Here's your account overview</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total students -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total students</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ isLoading ? '...' : stats.totalstudents }}
                        </h3>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
            <h3 class="text-xl font-bold text-gray-800">Recent Activities</h3>
            <ul class="mt-4 space-y-2">
                <li class="text-gray-600">User John Doe logged in</li>
                <li class="text-gray-600">User Jane Smith updated their profile</li>
                <li class="text-gray-600">New category "AI Tools" added</li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
            <h3 class="text-xl font-bold text-gray-800">Quick Links</h3>
            <div class="mt-4 space-y-2">
                <a href="#" class="text-indigo-600 hover:underline p-5">Manage Users</a>
                <a href="#" class="text-indigo-600 hover:underline p-5">View Reports</a>
                <a href="#" class="text-indigo-600 hover:underline p-5">Settings</a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useUserStore } from '@/stores/userStore'
import axios from '@/axios'

const userStore = useUserStore()
const stats = ref({
    totalstudents: 0,
    totalUsers: 0,
    totalCategories: 0
})
const isLoading = ref(true)

</script>