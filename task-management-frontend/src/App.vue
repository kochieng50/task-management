<template>
  <div style="min-height: 100vh; background-color: #f3f4f6">
    <Navbar v-if="isAuthenticated" />
    <Sidebar
      v-if="isAuthenticated"
      :isSidebarOpen="isSidebarOpen"
      @toggle-sidebar="toggleSidebar"
    />
    <div
      style="
        padding-top: 4rem;
        padding-bottom: 4rem;
        min-height: 100vh;
        box-sizing: border-box;
        transition: margin-left 0.3s ease;
      "
      :style="{ 'margin-left': isAuthenticated && isSidebarOpen ? '16rem' : '0' }"
    >
      <router-view />
    </div>
    <Footer v-if="isAuthenticated" />
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import Navbar from './components/Navbar.vue'
import Sidebar from './components/Sidebar.vue'
import Footer from './components/Footer.vue'

const isAuthenticated = computed(() => !!localStorage.getItem('token'))
const isSidebarOpen = ref(localStorage.getItem('sidebarOpen') !== 'false')

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
  localStorage.setItem('sidebarOpen', isSidebarOpen.value)
}
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
