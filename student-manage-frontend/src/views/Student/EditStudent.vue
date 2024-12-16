<template>
  <div class="max-w-4xl mx-auto p-6 space-y-8">
    <!-- Header with blue gradient -->
    <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-500 rounded-2xl p-6 text-white shadow-lg">
      <h1 class="text-2xl font-bold">Edit Student</h1>
      <p class="text-blue-100 mt-1">Update the information below to modify this Student</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6">
      <form v-if="Student" @submit.prevent="handleSubmit" class="space-y-6">
        
        <!-- Name Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700 block">
            Name
            <span class="text-red-500">*</span>
          </label>
          <input 
            v-model="Student.name"
            type="text"
            required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition-colors bg-white/50"
            placeholder="Enter Student name"
          />
        </div>

        <!-- Grade Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700 block">
            Grade
            <span class="text-red-500">*</span>
          </label>
          <input 
            v-model="Student.grade"
            type="text"
            required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition-colors bg-white/50"
            placeholder="Enter Student grade"
          />
        </div>

        <!-- Phone Number Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700 block">
            Phone Number
            <span class="text-red-500">*</span>
          </label>
          <input 
            v-model="Student.phno"
            type="text"
            required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition-colors bg-white/50"
            placeholder="Enter Student phone number"
          />
        </div>

        <!-- Address Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700 block">
            Address
            <span class="text-red-500">*</span>
          </label>
          <input 
            v-model="Student.address"
            type="text"
            required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition-colors bg-white/50"
            placeholder="Enter Student address"
          />
        </div>

        <!-- Date of Birth Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-700 block">
            Date of Birth
            <span class="text-red-500">*</span>
          </label>
          <input 
            v-model="Student.date_of_birth"
            type="date"
            required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 
                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   transition-colors bg-white/50"
          />
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-4">
          <button
            type="submit"
            :disabled="isLoading"
            class="flex-1 px-6 py-3 rounded-xl text-white font-medium
                   bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-500
                   hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200
                   disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="isLoading" class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Saving...
            </span>
            <span v-else>Save Changes</span>
          </button>

          <button
            type="button"
            @click="$router.push('/students')"
            class="px-6 py-3 rounded-xl text-gray-700 font-medium bg-gray-100 
                   hover:bg-gray-200 hover:shadow-lg transform hover:-translate-y-0.5 
                   transition-all duration-200"
          >
            Cancel
          </button>
        </div>
      </form>

      <!-- Loading State -->
      <div v-else class="flex items-center justify-center py-12">
        <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import axios from '@/axios'
import { useNotificationStore } from '@/stores/notificationStore'

export default {
  data() {
    return {
      Student: null,
      isLoading: false
    }
  },
  methods: {
    async fetchStudent() {
      try {
        const response = await axios.get(`/students/${this.$route.params.id}`)
        this.Student = response.data
      } catch (error) {
        useNotificationStore().error('Error fetching Student')
      }
    },
    async handleSubmit() {
      this.isLoading = true
      try {
        await axios.put(`/students/${this.Student.id}`, this.Student)
        useNotificationStore().success('Student updated successfully')
        this.$router.push('/students')
      } catch (error) {
        useNotificationStore().error('Error updating Student')
      } finally {
        this.isLoading = false
      }
    }
  },
  created() {
    this.fetchStudent()
  }
}
</script>