import { defineStore } from 'pinia'

export const useNotificationStore = defineStore('notification', {
  state: () => ({
    notifications: []
  }),

  actions: {
    add(notification) {
      const id = Date.now()
      this.notifications.push({
        id,
        message: notification.message,
        type: notification.type || 'error',
        timeout: notification.timeout || 5000
      })

      // Auto remove notification
      setTimeout(() => {
        this.remove(id)
      }, notification.timeout || 5000)
    },

    remove(id) {
      this.notifications = this.notifications.filter(note => note.id !== id)
    },

    error(message) {
      this.add({ message, type: 'error' })
    },

    success(message) {
      this.add({ message, type: 'success' })
    },

    warning(message) {
      this.add({ message, type: 'warning' })
    }
  }
})