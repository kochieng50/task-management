<template>
  <footer
    v-if="isAuthenticated"
    style="
      background-color: #ffffff;
      box-shadow:
        0 -4px 6px -1px rgba(0, 0, 0, 0.1),
        0 -2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 1rem;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 5;
    "
  >
    <p style="font-size: 0.875rem; color: #6b7280">
      &copy; 2025 Task Manager. All rights reserved.
    </p>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const isAuthenticated = computed(() => !!localStorage.getItem('token'))
</script>

<style>
/* Inline styles are used above, so this block remains empty. */
</style>
