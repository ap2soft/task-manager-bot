<template>
  <TelegramWebAppLayout>
    <Head :title="task.title" />

    <nav>
      <Link
        :href="route('twa.tasks.index')"
        class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400"
      >
        <ChevronLeftIcon class="size-4 fill-gray-400 dark:fill-gray-500" />
        <span>Tasks</span>
      </Link>
    </nav>

    <article class="mt-4">
      <h1 class="text-2xl/8 font-bold text-gray-700 dark:text-gray-300">{{ task.title }}</h1>
      <p class="mt-2 inline-flex items-center gap-2 text-gray-500">
        <time :datetime="task.date">{{ taskDate }}</time>
      </p>
      <div class="mt-4 text-gray-600 dark:text-gray-400">{{ task.text }}</div>
      <div class="mt-6 border-t border-gray-600 py-4">
        <div class="flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400">
          <BellIcon class="size-4" />
          <span>{{ reminderTime }}</span>
        </div>
      </div>
      <div class="mt-6">
        <SecondaryButton @click="confirmTaskDeletion">Delete</SecondaryButton>
      </div>
      <Modal :show="confirmingTaskDeletion" @close="closeModal">
        <div class="p-6">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Are you sure you want to delete this task?
          </h2>

          <div class="mt-6 flex justify-end">
            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
            <DangerButton
              class="ms-3"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              @click="deleteTask"
            >
              Delete task
            </DangerButton>
          </div>
        </div>
      </Modal>
    </article>
  </TelegramWebAppLayout>
</template>

<script setup>
import TelegramWebAppLayout from '@/Layouts/TelegramWebAppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { formatDistanceStrict, intlFormat } from 'date-fns'
import { ru } from 'date-fns/locale/ru'
import { BellIcon, ChevronLeftIcon } from '@heroicons/vue/16/solid'
import { computed, ref } from 'vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
  task: Object,
})

const taskDate = computed(() =>
  intlFormat(
    props.task.date,
    { year: 'numeric', month: 'short', day: 'numeric', weekday: 'short', hour: '2-digit', minute: '2-digit' },
    { locale: 'ru-RU' }
  )
)

const reminderTime = computed(() => {
  let reminders = []
  if (props.task.notify_at && props.task.notify_at !== props.task.date) {
    reminders.push(`за ${formatDistanceStrict(props.task.notify_at, props.task.date, { locale: ru })}`)
  }
  reminders.push(`во время события`)
  return reminders.join(', ')
})

const confirmingTaskDeletion = ref(false)
const confirmTaskDeletion = () => {
  confirmingTaskDeletion.value = true
}
const closeModal = () => {
  confirmingTaskDeletion.value = false
}
let tg = window.Telegram.WebApp
let form = useForm({
  initData: tg.initData,
})
const deleteTask = () => {
  form.delete(route('twa.tasks.destroy', props.task.id))
}
</script>
