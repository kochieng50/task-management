<template>
  <nav
    v-if="isAuthenticated"
    style="
      background-color: #ffffff;
      box-shadow:
        0 4px 6px -1px rgba(0, 0, 0, 0.1),
        0 2px 4px -1px rgba(0, 0, 0, 0.06);
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 10;
    "
  >
    <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem">
      <div style="display: flex; justify-content: space-between; align-items: center; height: 4rem">
        <div style="display: flex; align-items: center">
          <router-link
            to="/dashboard"
            style="font-size: 1.5rem; font-weight: 700; color: #2563eb; text-decoration: none"
          >
            Task Manager
          </router-link>
          <div style="display: flex; margin-left: 1.5rem; gap: 2rem">
            <router-link
              to="/dashboard"
              style="
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition:
                  color 0.2s,
                  border-color 0.2s;
              "
              :style="{
                'border-bottom':
                  '2px solid ' + ($route.path === '/dashboard' ? '#2563eb' : 'transparent'),
                color: $route.path === '/dashboard' ? '#111827' : '#6b7280',
              }"
            >
              Dashboard
            </router-link>
            <router-link
              to="/tasks"
              style="
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition:
                  color 0.2s,
                  border-color 0.2s;
              "
              :style="{
                'border-bottom':
                  '2px solid ' + ($route.path.startsWith('/tasks') ? '#2563eb' : 'transparent'),
                color: $route.path.startsWith('/tasks') ? '#111827' : '#6b7280',
              }"
            >
              Tasks
            </router-link>
          </div>
        </div>
        <div style="position: relative; display: flex; align-items: center">
          <img
            :src="user.avatar_url || 'https://via.placeholder.com/40'"
            alt="User Avatar"
            style="
              width: 2.5rem;
              height: 2.5rem;
              border-radius: 50%;
              object-fit: cover;
              cursor: pointer;
              border: 2px solid #e5e7eb;
            "
            @mouseover="showDropdown = true"
            @mouseout="showDropdown = false"
          />
          <div
            v-if="showDropdown"
            style="
              position: absolute;
              top: 3rem;
              right: 0;
              background-color: #ffffff;
              border-radius: 0.5rem;
              box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
              padding: 1rem;
              min-width: 12rem;
              z-index: 20;
              transition: opacity 0.2s ease;
            "
            @mouseover="showDropdown = true"
            @mouseout="showDropdown = false"
          >
            <p
              v-if="!isLoading"
              style="font-size: 0.875rem; font-weight: 600; color: #1f2a44; margin-bottom: 0.5rem"
            >
              {{ user.name || 'User' }}
            </p>
            <p
              v-if="isLoading"
              style="font-size: 0.875rem; font-weight: 600; color: #1f2a44; margin-bottom: 0.5rem"
            >
              Loading...
            </p>
            <p style="font-size: 0.75rem; color: #6b7280; margin-bottom: 1rem">
              {{ user.email || 'user@example.com' }}
            </p>
            <button
              @click="logout"
              style="
                width: 100%;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: #ffffff;
                background-color: #ef4444;
                border: none;
                text-align: left;
                cursor: pointer;
                transition: background-color 0.2s;
              "
              @mouseover="this.style.backgroundColor = '#dc2626'"
              @mouseout="this.style.backgroundColor = '#ef4444'"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '../services/api'

const router = useRouter()
const route = useRoute()
const isAuthenticated = computed(() => !!localStorage.getItem('token'))
const user = ref({ name: '', email: '', avatar_url: '' })
const showDropdown = ref(false)
const isLoading = ref(true)

const fetchUser = async () => {
  isLoading.value = true
  try {
    const response = await api.get('/user', {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    user.value = response.data || { name: '', email: '', avatar_url: '' }
  } catch (err) {
    console.error('Failed to fetch user:', err)
    user.value = { name: 'User', email: 'user@example.com', avatar_url: '' }
  } finally {
    isLoading.value = false
  }
}

const logout = async () => {
  try {
    await api.post(
      '/logout',
      {},
      {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
      },
    )
    localStorage.removeItem('token')
    localStorage.removeItem('sidebarOpen')
    router.push('/login')
  } catch (err) {
    console.error('Logout failed:', err.response?.data || err.message)
  }
}

onMounted(() => {
  if (isAuthenticated.value) fetchUser()
})
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
