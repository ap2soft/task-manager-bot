<template>
  <TelegramWebAppLayout>
    <Head title="Your tasks" />

    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-2xl/8 font-bold text-gray-950 dark:text-white">Your tasks</h1>
        <UserDetails class="mt-2" />
      </div>
      <PrimaryLink :href="route('twa.tasks.create', { initData })">Create</PrimaryLink>
    </div>

    <div class="mt-6">
      <nav aria-label="Directory">
        <template v-if="Object.keys(tasksByDate).length">
          <div v-for="date in Object.keys(tasksByDate)" :key="date" class="relative">
            <div
              class="border-y border-b-gray-200 border-t-gray-100 bg-gray-50 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-900 dark:border-b-gray-800 dark:border-t-gray-900 dark:bg-gray-900/50 dark:text-gray-100"
            >
              <h3>{{ date }}</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-900">
              <li v-for="task in tasksByDate[date]" :key="task.id" class="relative px-3 py-5">
                <div class="min-w-0">
                  <h2 class="min-w-0">
                    <Link
                      :href="route('twa.tasks.show', { task: task.id, initData })"
                      class="flex text-sm font-semibold leading-6 text-gray-900 dark:text-gray-200"
                      :title="task.title"
                    >
                      <span class="truncate">{{ task.title }}</span>
                      <span class="absolute inset-0"></span>
                    </Link>
                  </h2>
                  <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ task.time }}</p>
                </div>
              </li>
            </ul>
          </div>
        </template>
        <p v-else class="text-center text-gray-600 dark:text-gray-400">No tasks</p>
      </nav>

      <Pagination v-if="tasks?.links" :links="tasks.links" />
    </div>
  </TelegramWebAppLayout>
</template>

<script setup>
import TelegramWebAppLayout from '@/Layouts/TelegramWebAppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'
import { intlFormat } from 'date-fns'
import UserDetails from '@/Pages/TelegramWebApp/UserDetails.vue'
import Pagination from '@/Components/Pagination.vue'
import PrimaryLink from '@/Components/PrimaryLink.vue'

const props = defineProps({
  tasks: Object,
})

const tasksByDate = computed(() => {
  if (!props.tasks?.data.length) {
    return {}
  }
  return props.tasks.data.reduce((tasks, task) => {
    let date = intlFormat(task.date, { locale: 'ru-RU' })
    let time = intlFormat(task.date, { hour: '2-digit', minute: '2-digit' }, { locale: 'ru-RU' })
    tasks[date] ??= []
    tasks[date].push({ ...task, time })
    return tasks
  }, {})
})

let tg = window.Telegram.WebApp
let initData = computed(() => tg.initData)

onMounted(() => {
  tg.ready()
  // router.get(route('twa.tasks.list', { initData }))
  router.reload({ only: ['tasks'], data: { initData: initData.value } })
})
</script>
