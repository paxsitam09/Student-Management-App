<template>
  <main class="flex-grow mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    <RouterView v-slot="{ Component }">
      <transition
        name="fade"
        mode="out-in"
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 translate-y-1"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-1"
      >
        <component :is="Component" />
      </transition>
    </RouterView>
    <NotificationToast/>
  </main>
</template>
<script setup>
import NotificationToast from '@/components/NotificationToast.vue';
</script>