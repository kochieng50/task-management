<template>
  <div
    style="
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
      padding: 2rem 1rem;
      transition: margin-left 0.3s ease;
    "
    :style="{ 'margin-left': sidebarOpen ? '1rem' : '0' }"
  >
    <div
      style="
        max-width: 80rem;
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      "
    >
      <h2 style="font-size: 1.75rem; font-weight: 600; color: #1f2937">Dashboard</h2>

      <div
        style="
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr));
          gap: 1rem;
        "
      >
        <div style="flex: 1; min-width: 10rem; max-width: 1rem">
          <label
            style="
              font-size: 0.875rem;
              font-weight: 500;
              color: #374151;
              margin-bottom: 0.25rem;
              display: block;
            "
          >
            Search by Title
          </label>
          <input
            v-model="filters.title"
            placeholder="Enter task title"
            style="
              padding: 0.5rem 0.75rem;
              border: 1px solid #d1d5db;
              border-radius: 0.375rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)'"
            @blur="this.style.boxShadow = 'none'"
            @input="debouncedFetchTasks"
          />
        </div>
        <div style="flex: 1; min-width: 10rem; max-width: 12rem">
          <label
            style="
              font-size: 0.875rem;
              font-weight: 500;
              color: #374151;
              margin-bottom: 0.25rem;
              display: block;
            "
          >
            Status
          </label>
          <select
            v-model="filters.status"
            style="
              padding: 0.5rem 0.75rem;
              border: 1px solid #d1d5db;
              border-radius: 0.375rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              background-color: #ffffff;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)'"
            @blur="this.style.boxShadow = 'none'"
            @change="debouncedFetchTasks"
          >
            <option value="">All Tasks</option>
            <option value="pending">Pending</option>
            <option value="overdue">Overdue</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div style="flex: 1; min-width: 10rem; max-width: 12rem">
          <label
            style="
              font-size: 0.875rem;
              font-weight: 500;
              color: #374151;
              margin-bottom: 0.25rem;
              display: block;
            "
          >
            Priority
          </label>
          <select
            v-model="filters.priority"
            style="
              padding: 0.5rem 0.75rem;
              border: 1px solid #d1d5db;
              border-radius: 0.375rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              background-color: #ffffff;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)'"
            @blur="this.style.boxShadow = 'none'"
            @change="debouncedFetchTasks"
          >
            <option value="">All Priorities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>
        <div style="flex: 1; min-width: 10rem; max-width: 12rem">
          <label
            style="
              font-size: 0.875rem;
              font-weight: 500;
              color: #374151;
              margin-bottom: 0.25rem;
              display: block;
            "
          >
            Due Date (Start)
          </label>
          <input
            v-model="filters.dueDateStart"
            type="date"
            style="
              padding: 0.5rem 0.75rem;
              border: 1px solid #d1d5db;
              border-radius: 0.375rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)'"
            @blur="this.style.boxShadow = 'none'"
            @change="debouncedFetchTasks"
          />
        </div>
        <div style="flex: 1; min-width: 10rem; max-width: 12rem">
          <label
            style="
              font-size: 0.875rem;
              font-weight: 500;
              color: #374151;
              margin-bottom: 0.25rem;
              display: block;
            "
          >
            Due Date (End)
          </label>
          <input
            v-model="filters.dueDateEnd"
            type="date"
            style="
              padding: 0.5rem 0.75rem;
              border: 1px solid #d1d5db;
              border-radius: 0.375rem;
              width: 100%;
              font-size: 0.875rem;
              color: #374151;
              outline: none;
              transition:
                border-color 0.2s,
                box-shadow 0.2s;
            "
            @focus="this.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)'"
            @blur="this.style.boxShadow = 'none'"
            @change="debouncedFetchTasks"
          />
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: flex-end; min-width: 10rem">
          <button
            @click="fetchTasks"
            :disabled="isLoading"
            style="
              padding: 0.5rem 1rem;
              border-radius: 0.375rem;
              font-size: 0.875rem;
              font-weight: 500;
              color: #ffffff;
              background-color: #3b82f6;
              border: none;
              transition:
                background-color 0.2s,
                transform 0.2s;
              cursor: pointer;
            "
            :style="{
              opacity: isLoading ? '0.6' : '1',
              cursor: isLoading ? 'not-allowed' : 'pointer',
            }"
            @mouseover="!isLoading && (this.style.backgroundColor = '#2563eb')"
            @mouseout="!isLoading && (this.style.backgroundColor = '#3b82f6')"
          >
            {{ isLoading ? 'Searching...' : 'Search' }}
          </button>
          <button
            @click="clearFilters"
            :disabled="isLoading"
            style="
              padding: 0.5rem 1rem;
              border-radius: 0.375rem;
              font-size: 0.875rem;
              font-weight: 500;
              color: #4b5563;
              background-color: #f3f4f6;
              border: none;
              transition:
                background-color 0.2s,
                transform 0.2s;
              cursor: pointer;
            "
            :style="{
              opacity: isLoading ? '0.6' : '1',
              cursor: isLoading ? 'not-allowed' : 'pointer',
            }"
            @mouseover="!isLoading && (this.style.backgroundColor = '#e5e7eb')"
            @mouseout="!isLoading && (this.style.backgroundColor = '#f3f4f6')"
          >
            Clear Filters
          </button>
        </div>
      </div>

      <div
        style="
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr));
          gap: 1rem;
        "
      >
        <div
          style="
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          <h3 style="font-size: 1rem; font-weight: 500; color: #374151">Total Tasks</h3>
          <p style="font-size: 1.5rem; font-weight: 600; color: #3b82f6; margin-top: 0.25rem">
            {{ stats.total }}
          </p>
        </div>
        <div
          style="
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          <h3 style="font-size: 1rem; font-weight: 500; color: #374151">Pending Tasks</h3>
          <p style="font-size: 1.5rem; font-weight: 600; color: #3b82f6; margin-top: 0.25rem">
            {{ stats.pending }}
          </p>
        </div>
        <div
          style="
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          <h3 style="font-size: 1rem; font-weight: 500; color: #374151">Overdue Tasks</h3>
          <p style="font-size: 1.5rem; font-weight: 600; color: #ef4444; margin-top: 0.25rem">
            {{ stats.overdue }}
          </p>
        </div>
        <div
          style="
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          <h3 style="font-size: 1rem; font-weight: 500; color: #374151">Completion Rate</h3>
          <div
            style="
              margin-top: 0.25rem;
              position: relative;
              width: 60px;
              height: 60px;
              margin: 0.5rem auto;
            "
          >
            <svg style="width: 100%; height: 100%">
              <circle style="fill: none; stroke: #e5e7eb; stroke-width: 8; r: 26; cx: 30; cy: 30" />
              <circle
                style="
                  fill: none;
                  stroke: #22c55e;
                  stroke-width: 8;
                  r: 26;
                  cx: 30;
                  cy: 30;
                  stroke-dasharray: 163;
                  stroke-dashoffset: calc(163 - (163 * {{ completionRate }}) / 100);
                  transform: rotate(-90deg);
                  transform-origin: 50% 50%;
                  transition: stroke-dashoffset 0.5s ease;
                "
              />
            </svg>
            <span
              style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 0.875rem;
                font-weight: 500;
                color: #22c55e;
              "
            >
              {{ completionRate }}%
            </span>
          </div>
        </div>
      </div>

      <div
        style="
          background-color: #ffffff;
          padding: 1rem;
          border-radius: 0.5rem;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        "
      >
        <h3 style="font-size: 1rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem">
          Task Distribution
        </h3>
        <div
          style="
            display: flex;
            align-items: flex-end;
            gap: 0.75rem;
            height: 120px;
            flex-wrap: wrap;
            justify-content: center;
          "
        >
          <div
            style="
              flex: 1;
              display: flex;
              flex-direction: column;
              align-items: center;
              min-width: 4rem;
            "
          >
            <div
              style="
                background-color: #3b82f6;
                width: 100%;
                border-radius: 0.25rem;
                transition: height 0.5s ease;
              "
              :style="{ height: `${(stats.pending / maxStat) * 100}px` }"
            ></div>
            <span style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem">Pending</span>
            <span style="font-size: 0.75rem; font-weight: 500; color: #3b82f6">{{
              stats.pending
            }}</span>
          </div>
          <div
            style="
              flex: 1;
              display: flex;
              flex-direction: column;
              align-items: center;
              min-width: 4rem;
            "
          >
            <div
              style="
                background-color: #22c55e;
                width: 100%;
                border-radius: 0.25rem;
                transition: height 0.5s ease;
              "
              :style="{ height: `${(stats.completed / maxStat) * 100}px` }"
            ></div>
            <span style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem">Completed</span>
            <span style="font-size: 0.75rem; font-weight: 500; color: #22c55e">{{
              stats.completed
            }}</span>
          </div>
          <div
            style="
              flex: 1;
              display: flex;
              flex-direction: column;
              align-items: center;
              min-width: 4rem;
            "
          >
            <div
              style="
                background-color: #ef4444;
                width: 100%;
                border-radius: 0.25rem;
                transition: height 0.5s ease;
              "
              :style="{ height: `${(stats.overdue / maxStat) * 100}px` }"
            ></div>
            <span style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem">Overdue</span>
            <span style="font-size: 0.75rem; font-weight: 500; color: #ef4444">{{
              stats.overdue
            }}</span>
          </div>
        </div>
      </div>

      <div
        style="
          background-color: #ffffff;
          padding: 1rem;
          border-radius: 0.5rem;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        "
      >
        <h3 style="font-size: 1rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem">
          Recent Tasks
        </h3>
        <div
          v-if="recentTasks.length > 0"
          style="display: flex; flex-direction: column; gap: 0.5rem"
        >
          <div
            v-for="task in recentTasks"
            :key="task.id"
            style="
              display: flex;
              flex-wrap: wrap;
              justify-content: space-between;
              align-items: center;
              padding: 0.5rem 0.75rem;
              border-radius: 0.375rem;
              background-color: #f9fafb;
              transition:
                background-color 0.2s,
                transform 0.2s;
            "
            @mouseover="this.style.transform = 'scale(1.01)'"
            @mouseout="this.style.transform = 'scale(1)'"
          >
            <router-link
              :to="`/tasks/${task.id}`"
              style="
                font-size: 0.875rem;
                font-weight: 500;
                color: #3b82f6;
                text-decoration: none;
                flex: 1;
                min-width: 8rem;
              "
            >
              {{ task.title }}
            </router-link>
            <span
              style="font-size: 0.75rem; font-weight: 500; margin-right: 0.75rem; min-width: 5rem"
              :style="{ color: isOverdue(task.due_date) ? '#ef4444' : '#6b7280' }"
            >
              {{ formatDate(task.due_date) }}
            </span>
            <button
              @click="toggleTaskStatus(task)"
              :disabled="isLoading"
              style="
                padding: 0.25rem 0.5rem;
                border-radius: 0.375rem;
                font-size: 0.75rem;
                font-weight: 500;
                color: #ffffff;
                background-color: task.status === 'completed' ? '#22c55e' : '#6b7280';
                border: none;
                cursor: pointer;
                transition: background-color 0.2s;
              "
              :style="{
                opacity: isLoading ? '0.6' : '1',
                cursor: isLoading ? 'not-allowed' : 'pointer',
              }"
              @mouseover="
                !isLoading &&
                (this.style.backgroundColor = task.status === 'completed' ? '#16a34a' : '#4b5563')
              "
              @mouseout="
                !isLoading &&
                (this.style.backgroundColor = task.status === 'completed' ? '#22c55e' : '#6b7280')
              "
            >
              {{ isLoading ? 'Updating...' : task.status === 'completed' ? 'Undo' : 'Complete' }}
            </button>
          </div>
        </div>
        <p v-else style="font-size: 0.875rem; color: #6b7280; text-align: center">
          No recent tasks found.
        </p>
      </div>

      <div
        style="
          display: flex;
          justify-content: center;
          gap: 0.75rem;
          margin-top: 1.5rem;
          flex-wrap: wrap;
        "
      >
        <router-link
          to="/tasks"
          style="
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            background-color: #3b82f6;
            text-decoration: none;
            transition:
              background-color 0.2s,
              transform 0.2s;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          View All Tasks
        </router-link>
        <router-link
          to="/tasks/create"
          style="
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            background-color: #4b5563;
            text-decoration: none;
            transition:
              background-color 0.2s,
              transform 0.2s;
          "
          @mouseover="this.style.transform = 'scale(1.03)'"
          @mouseout="this.style.transform = 'scale(1)'"
        >
          Create New Task
        </router-link>
      </div>

      <p
        v-if="error"
        style="font-size: 0.875rem; color: #ef4444; text-align: center; margin-top: 0.75rem"
      >
        {{ error }}
      </p>

      <div
        v-if="toast.message"
        style="
          position: fixed;
          top: 0.75rem;
          right: 0.75rem;
          padding: 0.75rem 1rem;
          border-radius: 0.375rem;
          color: #ffffff;
          z-index: 50;
          transition: opacity 0.3s ease;
        "
        :style="{ backgroundColor: toast.type === 'success' ? '#22c55e' : '#ef4444' }"
      >
        {{ toast.message }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const stats = ref({
  total: 0,
  pending: 0,
  overdue: 0,
  completed: 0,
})

const tasks = ref([])
const filters = ref({
  title: '',
  status: '',
  priority: '',
  dueDateStart: '',
  dueDateEnd: '',
})
const error = ref('')
const isLoading = ref(false)
const toast = ref({ message: '', type: '' })
const sidebarOpen = ref(true)
const router = useRouter()

const debounce = (fn, delay) => {
  let timeoutId
  return (...args) => {
    clearTimeout(timeoutId)
    timeoutId = setTimeout(() => fn(...args), delay)
  }
}

const fetchTasks = async () => {
  isLoading.value = true
  try {
    const response = await api.get('/tasks', {
      params: {
        title: filters.value.title || undefined,
        status: filters.value.status === 'overdue' ? undefined : filters.value.status,
        priority: filters.value.priority || undefined,
        due_date_start: filters.value.dueDateStart || undefined,
        due_date_end: filters.value.dueDateEnd || undefined,
      },
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    })
    tasks.value = response.data.data || []
    updateStats()
    showToast('Filters applied successfully', 'success')
  } catch (err) {
    error.value = 'Failed to fetch tasks: ' + (err.response?.data?.message || err.message)
    showToast(error.value, 'error')
    console.error('Failed to fetch tasks:', err)
  } finally {
    isLoading.value = false
  }
}

const debouncedFetchTasks = debounce(fetchTasks, 500)

const clearFilters = () => {
  filters.value = {
    title: '',
    status: '',
    priority: '',
    dueDateStart: '',
    dueDateEnd: '',
  }
  fetchTasks()
}

const updateStats = () => {
  const filtered = tasks.value.filter((task) => {
    let matches = true
    if (filters.value.title) {
      matches = matches && task.title.toLowerCase().includes(filters.value.title.toLowerCase())
    }
    if (filters.value.status) {
      if (filters.value.status === 'pending') {
        matches = matches && task.status === 'pending'
      } else if (filters.value.status === 'overdue') {
        matches = matches && isOverdue(task.due_date)
      } else if (filters.value.status === 'completed') {
        matches = matches && task.status === 'completed'
      }
    }
    if (filters.value.priority) {
      matches = matches && task.priority === filters.value.priority
    }
    if (filters.value.dueDateStart || filters.value.dueDateEnd) {
      if (!task.due_date) return false
      const dueDate = new Date(task.due_date)
      const start = filters.value.dueDateStart ? new Date(filters.value.dueDateStart) : null
      const end = filters.value.dueDateEnd ? new Date(filters.value.dueDateEnd) : null
      matches =
        matches &&
        (!start || dueDate >= start) &&
        (!end || dueDate <= new Date(end.setHours(23, 59, 59, 999)))
    }
    return matches
  })

  stats.value = {
    total: filtered.length,
    pending: filtered.filter((task) => task.status === 'pending').length,
    overdue: filtered.filter((task) => isOverdue(task.due_date)).length,
    completed: filtered.filter((task) => task.status === 'completed').length,
  }
}

const completionRate = computed(() => {
  return stats.value.total > 0 ? Math.round((stats.value.completed / stats.value.total) * 100) : 0
})

const recentTasks = computed(() => {
  return tasks.value
    .filter((task) => {
      let matches = true
      if (filters.value.title) {
        matches = matches && task.title.toLowerCase().includes(filters.value.title.toLowerCase())
      }
      if (filters.value.status) {
        if (filters.value.status === 'pending') {
          matches = matches && task.status === 'pending'
        } else if (filters.value.status === 'overdue') {
          matches = matches && isOverdue(task.due_date)
        } else if (filters.value.status === 'completed') {
          matches = matches && task.status === 'completed'
        }
      }
      if (filters.value.priority) {
        matches = matches && task.priority === filters.value.priority
      }
      if (filters.value.dueDateStart || filters.value.dueDateEnd) {
        if (!task.due_date) return false
        const dueDate = new Date(task.due_date)
        const start = filters.value.dueDateStart ? new Date(filters.value.dueDateStart) : null
        const end = filters.value.dueDateEnd ? new Date(filters.value.dueDateEnd) : null
        matches =
          matches &&
          (!start || dueDate >= start) &&
          (!end || dueDate <= new Date(end.setHours(23, 59, 59, 999)))
      }
      return matches
    })
    .sort((a, b) => new Date(b.created_at || b.updated_at) - new Date(a.created_at || a.updated_at))
    .slice(0, 5)
})

const maxStat = computed(() => {
  return Math.max(stats.value.pending, stats.value.completed, stats.value.overdue, 1)
})

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

const toggleTaskStatus = async (task) => {
  isLoading.value = true
  try {
    const newStatus = task.status === 'completed' ? 'pending' : 'completed'
    await api.patch(
      `/tasks/${task.id}`,
      { status: newStatus },
      {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
      },
    )
    task.status = newStatus
    updateStats()
    showToast(`Task marked as ${newStatus}`, 'success')
  } catch (err) {
    error.value = 'Failed to update task status: ' + (err.response?.data?.message || err.message)
    showToast(error.value, 'error')
    console.error('Failed to update task status:', err)
  } finally {
    isLoading.value = false
  }
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
  div[style*='grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr))'] > div {
    flex: 1 1 100%;
    max-width: 100%;
  }
  div[style*='padding: 2rem 1rem'] {
    padding: 1.5rem 0.5rem;
  }
  div[style*='grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr))'] {
    grid-template-columns: 1fr;
  }
  div[style*='height: 120px'] {
    height: 80px;
    gap: 0.5rem;
  }
  div[style*='flex-wrap: wrap'][style*='justify-content: space-between'] {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.25rem;
  }
  div[style*='flex-wrap: wrap'][style*='justify-content: space-between'] > * {
    width: 100%;
    text-align: left;
  }
  div[style*='justify-content: center'][style*='flex-wrap: wrap'] {
    flex-direction: column;
    align-items: center;
  }
  div[style*='justify-content: center'][style*='flex-wrap: wrap'] > a {
    width: 100%;
    text-align: center;
    max-width: 1rem;
  }
  div[style*='position: fixed'] {
    top: 0.5rem;
    right: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
  }
}
</style>
