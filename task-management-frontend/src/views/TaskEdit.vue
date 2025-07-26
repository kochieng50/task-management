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
        Edit Task
      </h2>
      <form @submit.prevent="updateTask" style="display: flex; flex-direction: column; gap: 1.5rem">
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
            {{ isLoading ? 'Updating...' : 'Update Task' }}
          </button>
          <button
            type="button"
            @click="showDeleteModal = true"
            :disabled="isLoading"
            style="
              flex: 1;
              padding: 0.75rem 1rem;
              border-radius: 0.5rem;
              font-size: 0.875rem;
              font-weight: 600;
              color: #ffffff;
              background-color: #ef4444;
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
            Delete Task
          </button>
        </div>
        <router-link
          to="/tasks"
          style="
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background-color: #6b7280;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
            transition:
              background-color 0.2s,
              transform 0.2s;
          "
          @mouseover="this.style.transform = 'scale(1.05)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          Cancel
        </router-link>
      </form>
      <!-- Delete Confirmation Modal -->
      <div
        v-if="showDeleteModal"
        style="
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5);
          display: flex;
          align-items: center;
          justify-content: center;
          z-index: 50;
        "
      >
        <div
          style="
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow:
              0 10px 20px -5px rgba(0, 0, 0, 0.15),
              0 6px 8px -2px rgba(0, 0, 0, 0.1);
            max-width: 24rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
          "
        >
          <p style="font-size: 1rem; font-weight: 600; color: #1f2a44; text-align: center">
            Are you sure you want to delete this task?
          </p>
          <div style="display: flex; gap: 1rem; justify-content: center">
            <button
              @click="deleteTask"
              style="
                flex: 1;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 600;
                color: #ffffff;
                background-color: #ef4444;
                border: none;
                transition:
                  background-color 0.2s,
                  transform 0.2s;
                cursor: pointer;
              "
              @mouseover="this.style.transform = 'scale(1.05)'"
              @mouseout="this.style.transform = 'scale(1)'"
            >
              Delete
            </button>
            <button
              @click="showDeleteModal = false"
              style="
                flex: 1;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 600;
                color: #ffffff;
                background-color: #6b7280;
                border: none;
                transition:
                  background-color 0.2s,
                  transform 0.2s;
                cursor: pointer;
              "
              @mouseover="this.style.transform = 'scale(1.05)'"
              @mouseout="this.style.transform = 'scale(1)'"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
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
const showDeleteModal = ref(false)
const router = useRouter()
const route = useRoute()

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

const fetchTask = async () => {
  try {
    const response = await api.get(`/tasks/${route.params.id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    form.value = {
      title: response.data.title,
      description: response.data.description || '',
      due_date: response.data.due_date
        ? new Date(response.data.due_date).toISOString().split('T')[0]
        : '',
      priority: response.data.priority || 'medium',
      status: response.data.status || 'pending',
    }
  } catch (err) {
    error.value = 'Failed to fetch task'
  }
}

const updateTask = async () => {
  if (!validateForm()) return
  isLoading.value = true
  try {
    await api.put(`/tasks/${route.params.id}`, form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    router.push('/tasks')
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to update task'
  } finally {
    isLoading.value = false
  }
}

const deleteTask = async () => {
  isLoading.value = true
  try {
    await api.delete(`/tasks/${route.params.id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    router.push('/tasks')
  } catch (err) {
    error.value = 'Failed to delete task'
  } finally {
    isLoading.value = false
    showDeleteModal.value = false
  }
}

onMounted(() => fetchTask())
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
