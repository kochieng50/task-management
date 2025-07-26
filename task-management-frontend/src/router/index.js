import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import Dashboard from '../views/Dashboard.vue'
import Tasks from '../views/Tasks.vue'
import TaskCreate from '../views/TaskCreate.vue'
import TaskDetail from '../views/TaskDetail.vue'
import TaskEdit from '../views/TaskEdit.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/forgot-password', component: ForgotPassword },
  { path: '/dashboard', component: Dashboard },
  { path: '/tasks', component: Tasks },
  { path: '/tasks/create', component: TaskCreate },
  { path: '/tasks/:id', component: TaskDetail },
  { path: '/tasks/:id/edit', component: TaskEdit },
  { path: '/', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
