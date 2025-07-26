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
      <div style="text-align: center">
        <h2 style="font-size: 1.875rem; font-weight: 700; color: #1f2a44">Reset Password</h2>
        <p style="margin-top: 0.5rem; font-size: 0.875rem; color: #4b5563">
          Enter your email to receive a password reset link.
        </p>
      </div>
      <form
        @submit.prevent="resetPassword"
        style="display: flex; flex-direction: column; gap: 1.5rem"
      >
        <div style="display: flex; flex-direction: column; gap: 1rem">
          <div>
            <label
              for="email"
              style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151"
            >
              Email Address
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              placeholder="you@example.com"
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
              :style="
                error
                  ? { borderColor: '#ef4444', boxShadow: '0 0 0 2px rgba(239, 68, 68, 0.2)' }
                  : { borderColor: '#e5e7eb' }
              "
            />
          </div>
        </div>
        <p v-if="error" style="font-size: 0.875rem; color: #ef4444; text-align: center">
          {{ error }}
        </p>
        <p v-if="success" style="font-size: 0.875rem; color: #15803d; text-align: center">
          {{ success }}
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
          Send Reset Link
        </button>
        <div style="text-align: center">
          <router-link
            to="/login"
            style="font-size: 0.875rem; color: #2563eb; text-decoration: none"
          >
            Back to Sign In
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
  email: '',
})
const error = ref('')
const success = ref('')
const router = useRouter()

const resetPassword = async () => {
  try {
    await api.post('/forgot-password', form.value)
    success.value = 'Password reset link sent to your email.'
    error.value = ''
    form.value.email = ''
  } catch (err) {
    error.value = err.response?.data?.error || 'Failed to send reset link.'
    success.value = ''
  }
}
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
