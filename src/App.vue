<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="mx-auto min-h-dvh max-w-2xl rounded bg-white p-6 shadow-md">
    <header>
      <h1 class="text-center text-2xl font-bold text-pink-600">Hello</h1>

      <nav class="mt-2 flex items-center justify-center divide-x divide-gray-300">
        <RouterLink to="/" class="px-3 py-1 underline">Home</RouterLink>
        <RouterLink to="/about" class="px-3 py-1 underline">About</RouterLink>
      </nav>
    </header>

    <div class="mt-4">
      <RouterView />
    </div>
  </div>
</template>
