<template>
    <div class="min-h-[60vh] flex items-center justify-center p-4">
      <div class="text-center space-y-4">
        <!-- Error Code -->
        <div class="text-6xl font-bold text-gray-300">{{ errorCode }}</div>
        
        <!-- Error Title -->
        <h1 class="text-2xl font-semibold text-gray-800">{{ errorTitle }}</h1>
        
        <!-- Error Message -->
        <p class="text-gray-600">{{ errorMessage }}</p>
        
        <!-- Action Button -->
        <div class="pt-4">
          <RouterLink 
            to="/" 
            class="inline-flex items-center px-4 py-2 rounded-lg text-white font-medium
                   bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-500
                   hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
          >
            Return Home
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { computed } from 'vue'
  import { useRoute } from 'vue-router'
  import { useNotificationStore } from '@/stores/notificationStore'
  
  export default {
    setup() {
      const route = useRoute()
      const notificationStore = useNotificationStore()
  
      const errorCode = computed(() => route.params.code || '404')
  
      const errorMessages = {
        '400': {
          title: 'Bad Request',
          message: 'The request could not be understood by the server.',
          type: 'error'
        },
        '401': {
          title: 'Unauthorized',
          message: 'You need to be logged in to access this page.',
          type: 'warning'
        },
        '403': {
          title: 'Forbidden',
          message: 'You don\'t have permission to access this resource.',
          type: 'warning'
        },
        '404': {
          title: 'Page Not Found',
          message: 'The page you\'re looking for doesn\'t exist or has been moved.',
          type: 'warning'
        },
        '405': {
          title: 'Method Not Allowed',
          message: 'The requested method is not supported for this resource.',
          type: 'error'
        },
        '408': {
          title: 'Request Timeout',
          message: 'The server timed out waiting for the request.',
          type: 'error'
        },
        '422': {
          title: 'Validation Error',
          message: 'There were some duplicate errors. Please check the form again.',
          type: 'error'
        },
        '500': {
          title: 'Server Error',
          message: 'Something went wrong on our servers. Please try again later.',
          type: 'error'
        },
        '502': {
          title: 'Bad Gateway',
          message: 'The server received an invalid response from the upstream server.',
          type: 'error'
        },
        '503': {
          title: 'Service Unavailable',
          message: 'The server is temporarily unable to handle the request.',
          type: 'error'
        },
        'default': {
          title: 'Unexpected Error',
          message: 'An unexpected error occurred. Please try again later.',
          type: 'error'
        }
      }
  
      const errorInfo = computed(() => errorMessages[errorCode.value] || errorMessages.default)
      const errorTitle = computed(() => errorInfo.value.title)
      const errorMessage = computed(() => errorInfo.value.message)
  
      // Show notification
      notificationStore[errorInfo.value.type](errorInfo.value.message)
  
      return {
        errorCode,
        errorTitle,
        errorMessage
      }
    }
  }
  </script>