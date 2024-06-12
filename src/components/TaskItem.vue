<template>
  <div class="relative flex items-start py-4">
    <div class="min-w-0 flex-1 text-sm/6">
      <label
        :for="`task-${task.id}`"
        class="select-none font-medium"
        :class="{ 'line-through opacity-50': task.complete }"
      >
        {{ task.text }}
      </label>
    </div>
    <div class="ml-3 flex h-6 items-center">
      <input
        :id="`task-${task.id}`"
        :name="`task-${task.id}`"
        type="checkbox"
        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
        :checked="task.complete"
        @change="toggleTask"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  task: Object
})

const emit = defineEmits(['toggle-complete'])

const toggleTask = () => {
  emit('toggle-complete')
}
</script>
