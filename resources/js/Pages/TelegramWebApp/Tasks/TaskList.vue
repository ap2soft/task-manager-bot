<template>
  <TelegramWebAppLayout>
    <Head title="Your tasks"></Head>
    <h1 class="text-center text-2xl font-bold">Your tasks</h1>
    <UserDetails class="mt-2 text-center" />

    <div class="mt-6">
      <NewTask @new-task="addNewTask" />

      <div class="mt-4">
        <div v-if="tasks.length" class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
          <TaskItem v-for="task in sortedTasks" :key="task.id" :task @toggle-complete="toggleTaskComplete(task.id)" />
        </div>
        <p v-else>No tasks</p>
      </div>
    </div>
  </TelegramWebAppLayout>
</template>

<script setup>
import { computed, ref } from 'vue'
import TelegramWebAppLayout from '@/Layouts/TelegramWebAppLayout.vue'
import { Head } from '@inertiajs/vue3'
import NewTask from '@/Pages/TelegramWebApp/Tasks/NewTask.vue'
import TaskItem from '@/Pages/TelegramWebApp/Tasks/TaskItem.vue'
import UserDetails from '@/Pages/TelegramWebApp/UserDetails.vue'

let tasks = ref([
  {
    id: 1,
    text: 'First task',
    complete: false,
  },
])

let sortedTasks = computed(() => {
  return tasks.value.slice().sort((a, b) => a.complete - b.complete)
})

const addNewTask = (newTask) => {
  tasks.value.push({
    id: Math.floor(Math.random() * 10000) + 1,
    text: newTask,
    complete: false,
  })
}

const toggleTaskComplete = (taskId) => {
  let task = tasks.value.find(({ id }) => id === taskId)
  task.complete = !task.complete
  console.log(tasks.value)
}
</script>
