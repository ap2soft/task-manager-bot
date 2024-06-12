<template>
  <main>
    <h2 class="text-xl font-medium text-[var(--tg-theme-accent-text-color)]">Home page</h2>
    <UserDetails class="mt-1" />
    <TaskList class="mt-6" />
  </main>
</template>

<script setup lang="ts">
import UserDetails from '@/components/UserDetails.vue'
import TaskList from '@/components/TaskList.vue'
</script>
