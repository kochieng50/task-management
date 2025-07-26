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
    >
      <h2 style="text-align: center; font-size: 2rem; font-weight: 700; color: #1e3a8a">
        Create New Task
      </h2>
      <form @submit.prevent="createTask" style="display: flex; flex-direction: column; gap: 1.5rem">
        <div style="display: flex; flex-direction: column; gap: 1.5rem">
          <div>
            <label
              for="title"
              style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151"
            >
              Title <span style="color: #ef4444">*</span>
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              placeholder="Enter task title"
              style="
                margin-top: 0.25rem;
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
                outline: none;
                transition:
                  border-color 0.2s,
                  box-shadow 0.2s;
              "
              :style="{ 'border-color': errors.title ? '#ef4444' : '#d1d5db' }"
              @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
              @blur="this.style.boxShadow = 'none'"
            />
            <p v-if="errors.title" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem">
              {{ errors.title }}
            </p>
          </div>
          <div>
            <label
              for="description"
              style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151"
            >
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              placeholder="Enter task description"
              style="
                margin-top: 0.25rem;
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
                outline: none;
                min-height: 8rem;
                resize: vertical;
                transition:
                  border-color 0.2s,
                  box-shadow 0.2s;
              "
              @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
              @blur="this.style.boxShadow = 'none'"
            ></textarea>
          </div>
          <div>
            <label
              for="due_date"
              style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151"
            >
              Due Date <span style="color: #ef4444">*</span>
            </label>
            <input
              id="due_date"
              v-model="form.due_date"
              type="date"
              required
              style="
                margin-top: 0.25rem;
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
                outline: none;
                transition:
                  border-color 0.2s,
                  box-shadow 0.2s;
              "
              :style="{ 'border-color': errors.due_date ? '#ef4444' : '#d1d5db' }"
              @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
              @blur="this.style.boxShadow = 'none'"
            />
            <p
              v-if="errors.due_date"
              style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem"
            >
              {{ errors.due_date }}
            </p>
          </div>
          <div>
            <label
              for="priority"
              style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151"
            >
              Priority
            </label>
            <select
              id="priority"
              v-model="form.priority"
              style="
                margin-top: 0.25rem;
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
                outline: none;
                background-color: #ffffff;
                transition:
                  border-color 0.2s,
                  box-shadow 0.2s;
              "
              @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
              @blur="this.style.boxShadow = 'none'"
            >
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
          <div>
            <label
              for="status"
              style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151"
            >
              Status
            </label>
            <select
              id="status"
              v-model="form.status"
              style="
                margin-top: 0.25rem;
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
                outline: none;
                background-color: #ffffff;
                transition:
                  border-color 0.2s,
                  box-shadow 0.2s;
              "
              @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
              @blur="this.style.boxShadow = 'none'"
            >
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
            </select>
          </div>
        </div>
        <p v-if="error" style="font-size: 0.875rem; color: #ef4444; text-align: center">
          {{ error }}
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center">
          <button
            type="submit"
            :disabled="isLoading"
            style="
              flex: 1;
              padding: 0.75rem 1rem;
              border-radius: 0.5rem;
              font-size: 0.875rem;
              font-weight: 600;
              color: #ffffff;
              background-color: #2563eb;
              border: none;
              box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
              transition:
                background-color 0.2s,
                transform 0.2s;
              cursor: pointer;
            "
            :style="{
              opacity: isLoading ? '0.5' : '1',
              cursor: isLoading ? 'not-allowed' : 'pointer',
            }"
            @mouseover="!isLoading && (this.style.transform = 'scale(1.05)')"
            @mouseout="!isLoading && (this.style.transform = 'scale(1)')"
          >
            {{ isLoading ? 'Creating...' : 'Create Task' }}
          </button>
          <router-link
            to="/tasks"
            style="
              flex: 1;
              padding: 0.75rem 1rem;
              border-radius: 0.5rem;
              font-size: 0.875rem;
              font-weight: 600;
              color: #ffffff;
              background-color: #6b7280;
              text-decoration: none;
              box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
              text-align: center;
              transition:
                background-color 0.2s,
                transform 0.2s;
            "
            @mouseover="this.style.transform = 'scale(1.05)'"
            @mouseout="this.style.transform = 'scale(1)'"
          >
            Cancel
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const form = ref({
  title: '',
  description: '',
  due_date: '',
  priority: 'medium',
  status: 'pending',
})
const errors = ref({})
const error = ref('')
const isLoading = ref(false)
const router = useRouter()

const validateForm = () => {
  errors.value = {}
  let isValid = true
  if (!form.value.title.trim()) {
    errors.value.title = 'Title is required'
    isValid = false
  }
  if (!form.value.due_date) {
    errors.value.due_date = 'Due date is required'
    isValid = false
  } else if (new Date(form.value.due_date) < new Date().setHours(0, 0, 0, 0)) {
    errors.value.due_date = 'Due date cannot be in the past'
    isValid = false
  }
  return isValid
}

const createTask = async () => {
  if (!validateForm()) return
  isLoading.value = true
  try {
    await api.post('/tasks', form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    router.push('/tasks')
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to create task'
  } finally {
    isLoading.value = false
  }
}
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
