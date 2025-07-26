<template>
  <div
    style="
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%);
      padding: 3rem 1rem;
    "
  >
    <div
      style="
        max-width: 32rem;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow:
          0 10px 20px -5px rgba(0, 0, 0, 0.15),
          0 6px 8px -2px rgba(0, 0, 0, 0.1);
      "
      :style="{ 'background-color': isOverdue(task.due_date) ? '#fef2f2' : '#ffffff' }"
    >
      <h2 style="font-size: 2rem; font-weight: 700; color: #1e3a8a; text-align: center">
        {{ task.title }}
      </h2>
      <div style="display: flex; flex-direction: column; gap: 1rem">
        <p style="font-size: 0.875rem; color: #4b5563; text-align: center">
          {{ task.description || 'No description' }}
        </p>
        <p
          style="font-size: 0.875rem; text-align: center"
          :style="{ color: isOverdue(task.due_date) ? '#ef4444' : '#4b5563' }"
        >
          Due: {{ formatDate(task.due_date) }}
        </p>
        <p style="font-size: 0.875rem; text-align: center; color: #4b5563">
          Priority: <span style="font-weight: 600">{{ task.priority || 'Not set' }}</span>
        </p>
        <p style="font-size: 0.875rem; text-align: center; color: #4b5563">
          Status: <span style="font-weight: 600">{{ task.status || 'Not set' }}</span>
        </p>
        <button
          @click="toggleTaskStatus"
          :disabled="isLoading"
          style="
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background-color: task.status === 'completed' ? '#22c55e' : '#6b7280';
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
          "
          :style="{
            opacity: isLoading ? '0.5' : '1',
            cursor: isLoading ? 'not-allowed' : 'pointer',
          }"
          @mouseover="!isLoading && (this.style.transform = 'scale(1.05)')"
          @mouseout="!isLoading && (this.style.transform = 'scale(1)')"
        >
          {{
            isLoading
              ? 'Updating...'
              : task.status === 'completed'
                ? 'Mark as Pending'
                : 'Mark as Completed'
          }}
        </button>
      </div>
      <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem">
        <router-link
          to="/tasks"
          style="
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background-color: #2563eb;
            text-decoration: none;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
            transition:
              background-color 0.2s,
              transform 0.2s;
          "
          @mouseover="this.style.transform = 'scale(1.05)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          Back to Tasks
        </router-link>
        <router-link
          :to="`/tasks/${task.id}/edit`"
          style="
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background-color: #4b5563;
            text-decoration: none;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
            transition:
              background-color 0.2s,
              transform 0.2s;
          "
          @mouseover="this.style.transform = 'scale(1.05)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          Edit Task
        </router-link>
      </div>
      <p
        v-if="error"
        style="font-size: 0.875rem; color: #ef4444; text-align: center; margin-top: 1rem"
      >
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../services/api'

const task = ref({})
const error = ref('')
const isLoading = ref(false)
const route = useRoute()

const fetchTask = async () => {
  try {
    const response = await api.get(`/tasks/${route.params.id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    task.value = response.data
  } catch (err) {
    error.value = 'Failed to fetch task'
  }
}

const toggleTaskStatus = async () => {
  isLoading.value = true
  try {
    const newStatus = task.value.status === 'completed' ? 'pending' : 'completed'
    await api.patch(
      `/tasks/${task.value.id}`,
      { status: newStatus },
      {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
      },
    )
    task.value.status = newStatus
  } catch (err) {
    error.value = 'Failed to update task status: ' + (err.response?.data?.message || err.message)
  } finally {
    isLoading.value = false
  }
}

const isOverdue = (dueDate) => {
  return (
    dueDate &&
    new Date(dueDate) < new Date() &&
    new Date(dueDate).toDateString() !== new Date().toDateString()
  )
}

const formatDate = (date) => {
  return date ? new Date(date).toLocaleDateString() : 'No due date'
}

onMounted(() => fetchTask())
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
