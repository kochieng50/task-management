<template>
  <aside
    v-if="isAuthenticated && isSidebarOpen"
    style="
      position: fixed;
      top: 3.5rem;
      left: 0;
      width: 14rem;
      height: calc(100vh - 3.5rem);
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      z-index: 10;
      transition: transform 0.3s ease;
      transform: translateX(0);
    "
  >
    <button
      @click="$emit('toggle-sidebar')"
      style="
        align-self: flex-end;
        padding: 0.5rem;
        border: none;
        background: none;
        font-size: 1rem;
        color: #6b7280;
        cursor: pointer;
        transition: color 0.2s;
      "
      @mouseover="this.style.color = '#3b82f6'"
      @mouseout="this.style.color = '#6b7280'"
    >
      ✕
    </button>
    <nav style="display: flex; flex-direction: column; gap: 0.5rem">
      <router-link
        to="/dashboard"
        style="
          padding: 0.75rem 1rem;
          font-size: 0.875rem;
          font-weight: 500;
          color: #4b5563;
          text-decoration: none;
          border-radius: 0.375rem;
          transition: all 0.2s ease;
        "
        :style="{
          backgroundColor: $route.path === '/dashboard' ? '#f3f4f6' : 'transparent',
          color: $route.path === '/dashboard' ? '#111827' : '#4b5563',
        }"
        @mouseover="this.style.backgroundColor = '#f3f4f6'"
        @mouseout="
          this.style.backgroundColor = $route.path === '/dashboard' ? '#f3f4f6' : 'transparent'
        "
      >
        Dashboard
      </router-link>
      <router-link
        to="/tasks"
        style="
          padding: 0.75rem 1rem;
          font-size: 0.875rem;
          font-weight: 500;
          color: #4b5563;
          text-decoration: none;
          border-radius: 0.375rem;
          transition: all 0.2s ease;
        "
        :style="{
          backgroundColor: $route.path.startsWith('/tasks') ? '#f3f4f6' : 'transparent',
          color: $route.path.startsWith('/tasks') ? '#111827' : '#4b5563',
        }"
        @mouseover="this.style.backgroundColor = '#f3f4f6'"
        @mouseout="
          this.style.backgroundColor = $route.path.startsWith('/tasks') ? '#f3f4f6' : 'transparent'
        "
      >
        Tasks
      </router-link>
    </nav>
  </aside>
  <button
    v-if="isAuthenticated && !isSidebarOpen"
    @click="$emit('toggle-sidebar')"
    style="
      position: fixed;
      top: 4.5rem;
      left: 0.75rem;
      padding: 0.5rem 0.75rem;
      border-radius: 0.375rem;
      background-color: #3b82f6;
      color: #ffffff;
      border: none;
      font-size: 0.875rem;
      cursor: pointer;
      z-index: 11;
      transition: background-color 0.2s ease;
    "
    @mouseover="this.style.backgroundColor = '#2563eb'"
    @mouseout="this.style.backgroundColor = '#3b82f6'"
  >
    ☰
  </button>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

defineProps({
  isSidebarOpen: Boolean,
})
defineEmits(['toggle-sidebar'])

const route = useRoute()
const isAuthenticated = computed(() => !!localStorage.getItem('token'))
</script>

<style>
/* Inline styles used above */
</style>
