<template>
  <form class="flex items-center gap-3" @submit.prevent="addTask">
    <div class="w-full">
      <label for="new_task" class="sr-only">Add new task</label>
      <input
        type="text"
        name="new_task"
        id="new_task"
        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
        placeholder="New task, e.g. 'Host a fancy dinner party for imaginary friends'"
        autocomplete="off"
        v-model="newTask"
      />
    </div>
    <button
      type="submit"
      class="inline-flex w-auto items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:cursor-not-allowed disabled:bg-opacity-50"
      :disabled="!newTask.length"
    >
      Add
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue'

let newTask = ref('')

const emit = defineEmits(['new-task'])

const addTask = () => {
  if (!newTask.value.length) {
    return
  }
  emit('new-task', newTask.value)
  newTask.value = ''
}
</script>
