<template>
  <div>
    <NewTask @new-task="addNewTask" />

    <div class="mt-4">
      <div
        v-if="tasks.length"
        class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200"
      >
        <TaskItem
          v-for="task in sortedTasks"
          :key="task.id"
          :task
          @toggle-complete="toggleTaskComplete(task.id)"
        />
      </div>
      <p v-else>No tasks</p>
    </div>
  </div>
</template>

<script setup>
import NewTask from '@/components/NewTask.vue'
import { computed, ref } from 'vue'
import TaskItem from '@/components/TaskItem.vue'

let tasks = ref([
  {
    id: 1,
    text: 'First task',
    complete: false
  }
])

let sortedTasks = computed(() => {
  return tasks.value.slice().sort((a, b) => a.complete - b.complete)
})

const addNewTask = (newTask) => {
  tasks.value.push({
    id: Math.floor(Math.random() * 10000) + 1,
    text: newTask,
    complete: false
  })
}

const toggleTaskComplete = (taskId) => {
  let task = tasks.value.find(({ id }) => id === taskId)
  task.complete = !task.complete
  console.log(tasks.value)
}
</script>
