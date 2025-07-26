<template>
  <div
    style="
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%);
      padding: 3rem 1rem;
      transition: margin-left 0.3s ease;
    "
    :style="{ 'margin-left': sidebarOpen ? '1rem' : '0' }"
  >
    <div
      style="
        max-width: 72rem;
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
      <h2 style="font-size: 2rem; font-weight: 700; color: #1e3a8a">My Tasks</h2>
      <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center">
        <div style="flex: 1; min-width: 12rem; max-width: 1rem">
          <label
            style="
              display: block;
              font-size: 0.875rem;
              font-weight: 600;
              color: #1f2a44;
              margin-bottom: 0.25rem;
            "
          >
            Search by Title
          </label>
          <input
            v-model="search.title"
            placeholder="Enter task title"
            style="
              padding: 0.75rem 1rem;
              border: 1px solid #d1d5db;
              border-radius: 0.5rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
            @blur="this.style.boxShadow = 'none'"
            @input="debouncedFetchTasks"
          />
        </div>
        <div style="flex: 1; min-width: 12rem; max-width: 12rem">
          <label
            style="
              display: block;
              font-size: 0.875rem;
              font-weight: 600;
              color: #1f2a44;
              margin-bottom: 0.25rem;
            "
          >
            Due Date
          </label>
          <input
            v-model="search.due_date"
            type="date"
            style="
              padding: 0.75rem 1rem;
              border: 1px solid #d1d5db;
              border-radius: 0.5rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)'"
            @blur="this.style.boxShadow = 'none'"
            @change="debouncedFetchTasks"
          />
        </div>
        <div style="flex: 1; min-width: 12rem; max-width: 12rem">
          <label
            style="
              display: block;
              font-size: 0.875rem;
              font-weight: 600;
              color: #1f2a44;
              margin-bottom: 0.25rem;
            "
          >
            Priority
          </label>
          <select
            v-model="search.priority"
            style="
              padding: 0.75rem 1rem;
              border: 1px solid #d1d5db;
              border-radius: 0.5rem;
              width: 100%;
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
            @change="debouncedFetchTasks"
          >
            <option value="">All Priorities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>
        <div style="flex: 1; min-width: 12rem; max-width: 12rem">
          <label
            style="
              display: block;
              font-size: 0.875rem;
              font-weight: 600;
              color: #1f2a44;
              margin-bottom: 0.25rem;
            "
          >
            Status
          </label>
          <select
            v-model="search.status"
            style="
              padding: 0.75rem 1rem;
              border: 1px solid #d1d5db;
              border-radius: 0.5rem;
              width: 100%;
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
            @change="debouncedFetchTasks"
          >
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div style="flex: 1; min-width: 12rem; max-width: 12rem">
          <label
            style="
              display: block;
              font-size: 0.875rem;
              font-weight: 600;
              color: #1f2a44;
              margin-bottom: 0.25rem;
            "
          >
            Sort By
          </label>
          <select
            v-model="sort.field"
            @change="sortTasks"
            style="
              padding: 0.75rem 1rem;
              border: 1px solid #d1d5db;
              border-radius: 0.5rem;
              width: 100%;
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
            <option value="title">Sort by Title</option>
            <option value="due_date">Sort by Due Date</option>
          </select>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center; min-width: 12rem">
          <button
            @click="fetchTasks"
            :disabled="isLoading"
            style="
              padding: 0.75rem 1.5rem;
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
            {{ isLoading ? 'Searching...' : 'Search' }}
          </button>
          <button
            @click="clearFilters"
            :disabled="isLoading"
            style="
              padding: 0.75rem 1.5rem;
              border-radius: 0.5rem;
              font-size: 0.875rem;
              font-weight: 600;
              color: #ffffff;
              background-color: #6b7280;
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
            Clear Filters
          </button>
        </div>
        <router-link
          to="/tasks/create"
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
          Add Task
        </router-link>
        <button
          v-if="selectedTasks.length > 0"
          @click="showBulkDeleteModal = true"
          :disabled="isLoading"
          style="
            padding: 0.75rem 1.5rem;
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
          Delete Selected ({{ selectedTasks.length }})
        </button>
      </div>
      <div
        style="
          background-color: #ffffff;
          border-radius: 0.75rem;
          box-shadow:
            0 6px 12px -2px rgba(0, 0, 0, 0.1),
            0 3px 6px -1px rgba(0, 0, 0, 0.06);
          overflow-x: auto;
        "
      >
        <table style="width: 100%; border-collapse: collapse; min-width: 640px">
          <thead style="background: linear-gradient(145deg, #f9fafb, #f3f4f6)">
            <tr>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                "
              >
                <input type="checkbox" @change="toggleSelectAll" style="cursor: pointer" />
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Title
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Description
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Due Date
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Priority
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Status
              </th>
              <th
                style="
                  padding: 1rem 1.5rem;
                  font-size: 0.75rem;
                  font-weight: 600;
                  color: #1f2a44;
                  text-align: left;
                  text-transform: uppercase;
                "
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="task in tasks.data"
              :key="task.id"
              style="transition: background-color 0.2s"
              :style="{ 'background-color': isOverdue(task.due_date) ? '#fef2f2' : '#ffffff' }"
              @mouseover="
                this.style.backgroundColor = isOverdue(task.due_date) ? '#fee2e2' : '#f9fafb'
              "
              @mouseout="
                this.style.backgroundColor = isOverdue(task.due_date) ? '#fef2f2' : '#ffffff'
              "
            >
              <td style="padding: 1rem 1.5rem">
                <input
                  type="checkbox"
                  v-model="selectedTasks"
                  :value="task.id"
                  style="cursor: pointer"
                />
              </td>
              <td
                style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 500; color: #111827"
              >
                <router-link
                  :to="`/tasks/${task.id}`"
                  style="color: #2563eb; text-decoration: none"
                >
                  {{ task.title }}
                </router-link>
              </td>
              <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #6b7280">
                {{ task.description || 'No description' }}
              </td>
              <td
                style="padding: 1rem 1.5rem; font-size: 0.875rem"
                :style="{ color: isOverdue(task.due_date) ? '#ef4444' : '#6b7280' }"
              >
                {{ formatDate(task.due_date) }}
              </td>
              <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #6b7280">
                {{ task.priority || 'Not set' }}
              </td>
              <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #6b7280">
                {{ task.status || 'Not set' }}
              </td>
              <td style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 500">
                <router-link
                  :to="`/tasks/${task.id}/edit`"
                  style="color: #2563eb; text-decoration: none; margin-right: 1rem"
                >
                  Edit
                </router-link>
                <button
                  @click="deleteTask(task.id)"
                  style="
                    color: #ef4444;
                    background: none;
                    border: none;
                    cursor: pointer;
                    transition: color 0.2s;
                  "
                  @mouseover="this.style.color = '#dc2626'"
                  @mouseout="this.style.color = '#ef4444'"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div
        style="
          display: flex;
          justify-content: space-between;
          margin-top: 1.5rem;
          flex-wrap: wrap;
          gap: 1rem;
        "
      >
        <button
          @click="changePage(tasks.prev_page_url)"
          :disabled="!tasks.prev_page_url || isLoading"
          style="
            padding: 0.75rem 1.5rem;
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
            opacity: !tasks.prev_page_url || isLoading ? '0.5' : '1',
            cursor: !tasks.prev_page_url || isLoading ? 'not-allowed' : 'pointer',
          }"
          @mouseover="!isLoading && tasks.prev_page_url && (this.style.transform = 'scale(1.05)')"
          @mouseout="!isLoading && tasks.prev_page_url && (this.style.transform = 'scale(1)')"
        >
          Previous
        </button>
        <button
          @click="changePage(tasks.next_page_url)"
          :disabled="!tasks.next_page_url || isLoading"
          style="
            padding: 0.75rem 1.5rem;
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
            opacity: !tasks.next_page_url || isLoading ? '0.5' : '1',
            cursor: !tasks.next_page_url || isLoading ? 'not-allowed' : 'pointer',
          }"
          @mouseover="!isLoading && tasks.next_page_url && (this.style.transform = 'scale(1.05)')"
          @mouseout="!isLoading && tasks.next_page_url && (this.style.transform = 'scale(1)')"
        >
          Next
        </button>
      </div>
      <p
        v-if="error"
        style="font-size: 0.875rem; color: #ef4444; text-align: center; margin-top: 1rem"
      >
        {{ error }}
      </p>
      <!-- Bulk Delete Confirmation Modal -->
      <div
        v-if="showBulkDeleteModal"
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
            Delete {{ selectedTasks.length }} selected task(s)?
          </p>
          <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap">
            <button
              @click="bulkDeleteTasks"
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
                transition:
                  background-color 0.2s,
                  transform 0.2s;
                cursor: pointer;
                min-width: 8rem;
              "
              :style="{
                opacity: isLoading ? '0.5' : '1',
                cursor: isLoading ? 'not-allowed' : 'pointer',
              }"
              @mouseover="!isLoading && (this.style.transform = 'scale(1.05)')"
              @mouseout="!isLoading && (this.style.transform = 'scale(1)')"
            >
              {{ isLoading ? 'Deleting...' : 'Delete' }}
            </button>
            <button
              @click="showBulkDeleteModal = false"
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
                min-width: 8rem;
              "
              @mouseover="this.style.transform = 'scale(1.05)'"
              @mouseout="this.style.transform = 'scale(1)'"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
      <!-- Toast Notification -->
      <div
        v-if="toast.message"
        style="
          position: fixed;
          top: 1rem;
          right: 1rem;
          padding: 1rem 1.5rem;
          border-radius: 0.5rem;
          color: #ffffff;
          z-index: 50;
          transition: opacity 0.3s ease;
        "
        :style="{ 'background-color': toast.type === 'success' ? '#22c55e' : '#ef4444' }"
      >
        {{ toast.message }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const tasks = ref({})
const search = ref({ title: '', due_date: '', priority: '', status: '' })
const sort = ref({ field: 'title', order: 'asc' })
const selectedTasks = ref([])
const error = ref('')
const isLoading = ref(false)
const showBulkDeleteModal = ref(false)
const toast = ref({ message: '', type: '' })
const sidebarOpen = ref(true) // Adjust based on App.vue sidebar state
const router = useRouter()

// Debounce function to limit API calls
const debounce = (fn, delay) => {
  let timeoutId
  return (...args) => {
    clearTimeout(timeoutId)
    timeoutId = setTimeout(() => fn(...args), delay)
  }
}

const fetchTasks = async (url = '/tasks') => {
  isLoading.value = true
  try {
    const params = {
      title: search.value.title || undefined,
      due_date: search.value.due_date || undefined,
      priority: search.value.priority || undefined,
      status: search.value.status || undefined,
      sort: sort.value.field,
      order: sort.value.order,
    }
    const response = await api.get(url, {
      params,
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    tasks.value = response.data
    showToast('Tasks fetched successfully', 'success')
  } catch (err) {
    error.value = 'Failed to fetch tasks: ' + (err.response?.data?.message || err.message)
    showToast(error.value, 'error')
  } finally {
    isLoading.value = false
  }
}

const debouncedFetchTasks = debounce(fetchTasks, 500)

const clearFilters = () => {
  search.value = { title: '', due_date: '', priority: '', status: '' }
  fetchTasks()
}

const changePage = (url) => {
  if (url && !isLoading.value) {
    const pageUrl = new URL(url, window.location.origin)
    fetchTasks(`/tasks${pageUrl.search}`)
  }
}

const sortTasks = () => {
  sort.value.order = sort.value.order === 'asc' ? 'desc' : 'asc'
  fetchTasks()
}

const toggleSelectAll = (event) => {
  if (event.target.checked) {
    selectedTasks.value = tasks.value.data.map((task) => task.id)
  } else {
    selectedTasks.value = []
  }
}

const bulkDeleteTasks = async () => {
  if (!selectedTasks.value.length) return
  isLoading.value = true
  try {
    await Promise.all(
      selectedTasks.value.map((id) =>
        api.delete(`/tasks/${id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        }),
      ),
    )
    selectedTasks.value = []
    showToast('Tasks deleted successfully', 'success')
    fetchTasks()
  } catch (err) {
    error.value = 'Failed to delete tasks: ' + (err.response?.data?.message || err.message)
    showToast(error.value, 'error')
  } finally {
    isLoading.value = false
    showBulkDeleteModal.value = false
  }
}

const deleteTask = async (id) => {
  if (confirm('Are you sure you want to delete this task?')) {
    isLoading.value = true
    try {
      await api.delete(`/tasks/${id}`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
      })
      showToast('Task deleted successfully', 'success')
      fetchTasks()
    } catch (err) {
      error.value = 'Failed to delete task: ' + (err.response?.data?.message || err.message)
      showToast(error.value, 'error')
    } finally {
      isLoading.value = false
    }
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

const showToast = (message, type) => {
  toast.value = { message, type }
  setTimeout(() => (toast.value = { message: '', type: '' }), 3000)
}

onMounted(() => {
  fetchTasks()
  window.addEventListener('sidebar-toggle', (e) => {
    sidebarOpen.value = e.detail.isOpen
  })
})
</script>

<style>
@media (max-width: 640px) {
  div[style*='flex-wrap: wrap'] > div,
  div[style*='flex-wrap: wrap'] > button,
  div[style*='flex-wrap: wrap'] > a {
    flex: 1 1 100%;
    max-width: 100%;
  }
  div[style*='padding: 3rem 1rem'] {
    padding: 2rem 0.5rem;
  }
  table {
    min-width: 0;
  }
  th:nth-child(3),
  td:nth-child(3) {
    display: none;
  }
  th,
  td {
    padding: 0.75rem 0.5rem;
    font-size: 0.75rem;
  }
  div[style*='justify-content: space-between'][style*='margin-top: 1.5rem'] {
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
  }
  div[style*='justify-content: space-between'][style*='margin-top: 1.5rem'] > button {
    width: 100%;
    max-width: 1rem;
  }
  div[style*='position: fixed'] {
    top: 0.5rem;
    right: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
  }
}
</style>
