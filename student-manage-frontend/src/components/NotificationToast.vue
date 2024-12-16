<template>
    <div 
      class="fixed top-4 right-4 z-50 flex flex-col gap-2"
      style="min-width: 300px; max-width: 400px;"
    >
      <TransitionGroup 
        name="notification"
        tag="div"
        class="space-y-2"
      >
        <div
          v-for="notification in notifications"
          :key="notification.id"
          :class="[
            'rounded-lg shadow-lg p-4 transition-all duration-300 transform',
            {
              'bg-red-500 text-white': notification.type === 'error',
              'bg-green-500 text-white': notification.type === 'success',
              'bg-yellow-500 text-white': notification.type === 'warning'
            }
          ]"
          @click="notificationStore.remove(notification.id)"
        >
          <div class="flex items-start gap-2">
            <!-- Icons based on type -->
            <svg v-if="notification.type === 'error'"
              class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg v-if="notification.type === 'success'"
              class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg v-if="notification.type === 'warning'"
              class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            
            <p class="text-sm">{{ notification.message }}</p>
          </div>
        </div>
      </TransitionGroup>
    </div>
  </template>
  
  <script>
  import { useNotificationStore } from '@/stores/notificationStore'
  import { storeToRefs } from 'pinia'
  
  export default {
    setup() {
      const notificationStore = useNotificationStore()
      const { notifications } = storeToRefs(notificationStore)
  
      return {
        notifications,
        notificationStore
      }
    }
  }
  </script>
  
  <style scoped>
  .notification-enter-active,
  .notification-leave-active {
    transition: all 0.3s ease;
  }
  .notification-enter-from {
    opacity: 0;
    transform: translateX(30px);
  }
  .notification-leave-to {
    opacity: 0;
    transform: translateX(30px);
  }
  </style>