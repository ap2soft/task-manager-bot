<template>
  <TelegramWebAppLayout>
    <Head title="Your tasks" />
    <h1 class="text-center text-2xl font-bold text-gray-700 dark:text-gray-300">Your tasks</h1>
    <UserDetails class="mt-2 text-center" />

    <div class="mt-6">
      <form class="flex items-end gap-3" @submit.prevent="addNewTask">
        <div class="w-full">
          <InputLabel id="new_task">Add new task</InputLabel>
          <div class="mt-1 flex gap-2">
            <TextInput
              id="new_task"
              v-model="form.text"
              class="w-full"
              placeholder="New task, e.g. 'Host a fancy dinner party for imaginary friends'"
            />
            <PrimaryButton :disabled="!form.text.length || form.processing">Add</PrimaryButton>
          </div>
          <InputError class="mt-2" :message="form.errors.text" />
        </div>
      </form>

      <div class="mt-4">
        <template v-if="tasks?.data.length">
          <div
            class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200 dark:divide-gray-700 dark:border-gray-700"
          >
            <TaskItem v-for="task in tasks.data" :key="task.id" :task @toggle-complete="toggleTaskComplete(task.id)" />
          </div>

          <Pagination :links="tasks.links" />
        </template>
        <p v-else class="text-gray-600 dark:text-gray-400">No tasks</p>
      </div>
    </div>
  </TelegramWebAppLayout>
</template>

<script setup>
import TelegramWebAppLayout from '@/Layouts/TelegramWebAppLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import TaskItem from '@/Pages/TelegramWebApp/Tasks/TaskItem.vue'
import UserDetails from '@/Pages/TelegramWebApp/UserDetails.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue'
import Pagination from '@/Components/Pagination.vue'
import { onMounted } from 'vue'

const props = defineProps({
  tasks: Object,
})

let tg = window.Telegram.WebApp

onMounted(() => {
  tg.ready()

  router.reload({ only: ['tasks'], data: { initData: tg.initData } })
})

let form = useForm('post', route('twa.tasks.store'), {
  text: '',
  initData: tg.initData,
})

const addNewTask = () => {
  form.submit({
    preserveState: true,
    only: ['tasks'],
    onSuccess: () => form.reset(),
  })
}

const toggleTaskComplete = (taskId) => {
  let task = props.tasks.data.find(({ id }) => id === taskId)
  if (task.complete) {
    router.delete(route('twa.tasks.uncomplete', taskId), { only: ['tasks'] })
  } else {
    router.patch(route('twa.tasks.complete', taskId), null, { only: ['tasks'] })
  }
  task.complete = !task.complete
}
</script>
