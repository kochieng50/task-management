<template>
  <div
    style="
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f3f4f6;
      padding: 3rem 1rem;
    "
  >
    <div
      style="
        max-width: 28rem;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow:
          0 10px 15px -3px rgba(0, 0, 0, 0.1),
          0 4px 6px -2px rgba(0, 0, 0, 0.05);
      "
    >
      <h2 style="text-align: center; font-size: 1.875rem; font-weight: 700; color: #1f2a44">
        Create Account
      </h2>
      <p style="margin-top: 0.5rem; text-align: center; font-size: 0.875rem; color: #4b5563">
        Already have an account?
        <router-link to="/login" style="font-weight: 500; color: #2563eb; text-decoration: none">
          Sign in
        </router-link>
      </p>
      <form
        @submit.prevent="register"
        style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem"
      >
        <div style="display: flex; flex-direction: column; gap: 1rem">
          <div>
            <label
              for="name"
              style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151"
            >
              Name
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              placeholder="Enter your name"
              style="
                margin-top: 0.25rem;
                display: block;
                width: 100%;
                padding: 0.5rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                outline: none;
                font-size: 0.875rem;
              "
            />
          </div>
          <div>
            <label
              for="email"
              style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151"
            >
              Email
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              placeholder="Enter your email"
              style="
                margin-top: 0.25rem;
                display: block;
                width: 100%;
                padding: 0.5rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                outline: none;
                font-size: 0.875rem;
              "
            />
          </div>
          <div>
            <label
              for="password"
              style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151"
            >
              Password
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              placeholder="Enter your password"
              style="
                margin-top: 0.25rem;
                display: block;
                width: 100%;
                padding: 0.5rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                outline: none;
                font-size: 0.875rem;
              "
            />
          </div>
          <div>
            <label
              for="password_confirmation"
              style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151"
            >
              Confirm Password
            </label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              placeholder="Confirm your password"
              style="
                margin-top: 0.25rem;
                display: block;
                width: 100%;
                padding: 0.5rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                outline: none;
                font-size: 0.875rem;
              "
            />
          </div>
        </div>
        <p v-if="error" style="font-size: 0.875rem; color: #ef4444; text-align: center">
          {{ error }}
        </p>
        <button
          type="submit"
          style="
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            background-color: #2563eb;
            outline: none;
          "
        >
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})
const error = ref('')
const router = useRouter()

const register = async () => {
  try {
    const response = await api.post('/register', form.value)
    localStorage.setItem('token', response.data.token)
    router.push('/dashboard')
  } catch (err) {
    error.value = err.response?.data?.error || 'Registration failed'
  }
}
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
