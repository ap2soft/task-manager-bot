<template>
  <div class="relative flex items-start py-4">
    <div class="min-w-0 flex-1 text-sm/6">
      <InputLabel :class="{ 'line-through opacity-50': task.complete }">{{ task.text }}</InputLabel>
    </div>
    <div class="ml-3 flex h-6 items-center">
      <Checkbox :id="`task-${task.id}`" :checked="task.complete" @update:checked="toggleTask" />
    </div>
  </div>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue'
import Checkbox from '@/Components/Checkbox.vue'

defineProps({
  task: Object,
})

const emit = defineEmits(['toggle-complete'])

const toggleTask = () => {
  emit('toggle-complete')
}
</script>
