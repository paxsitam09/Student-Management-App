<template>
    <div 
      v-if="show" 
      class="fixed inset-0 bg-black-500 bg-opacity-75 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center gap-3 text-red-600">
          <ExclamationTriangleIcon class="w-6 h-6" />
          <h3 class="text-lg font-semibold">Confirm Deletion</h3>
        </div>
        
        <p class="text-gray-600">
          Are you sure you want to delete "<span class="font-medium">{{ StudentTitle }}</span>"? 
          This action cannot be undone.
        </p>
        
        <div class="flex gap-3 pt-2">
          <button
            @click="$emit('confirm')"
            class="flex-1 px-4 py-2 rounded-lg text-white font-medium
                   bg-red-600 hover:bg-red-700
                   transform hover:-translate-y-0.5 transition-all duration-200"
          >
            Yes, Delete
          </button>
          <button
            @click="$emit('cancel')"
            class="flex-1 px-4 py-2 rounded-lg text-gray-700 font-medium
                   bg-gray-100 hover:bg-gray-200
                   transform hover:-translate-y-0.5 transition-all duration-200"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid'
  
  export default {
    components: {
      ExclamationTriangleIcon
    },
    props: {
      show: {
        type: Boolean,
        default: false
      },
      StudentTitle: {
        type: String,
        default: ''
      }
    },
    emits: ['confirm', 'cancel']
  }
  </script>