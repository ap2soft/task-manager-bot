<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="bg-[var(--tg-theme-secondary-bg-color)]">
    <div
      class="mx-auto min-h-dvh max-w-2xl rounded bg-[var(--tg-theme-bg-color)] p-6 text-[var(--tg-theme-text-color)] shadow-md"
    >
      <header>
        <h1 class="text-center text-2xl font-bold text-[var(--tg-theme-section-header-text-color)]">
          TaskMaster
        </h1>

        <nav class="mt-4 flex items-center justify-center divide-x divide-gray-300">
          <RouterLink to="/" class="px-3 py-0.5 text-[var(--tg-theme-link-color)] underline">
            Home
          </RouterLink>
          <RouterLink to="/about" class="px-3 py-0.5 text-[var(--tg-theme-link-color)] underline">
            About
          </RouterLink>
        </nav>
      </header>

      <div class="mt-4">
        <RouterView />
      </div>
    </div>
  </div>
</template>
