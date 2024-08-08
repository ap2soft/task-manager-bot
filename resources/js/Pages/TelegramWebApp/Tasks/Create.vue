<template>
  <TelegramWebAppLayout>
    <Head title="Create task" />

    <nav>
      <Link
        :href="route('twa.tasks.index')"
        class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400"
      >
        <ChevronLeftIcon class="size-4 fill-gray-400 dark:fill-gray-500" />
        <span>Back</span>
      </Link>
    </nav>

    <article class="mt-6">
      <div class="flex items-center justify-between">
        <h2 class="text-balance text-lg/6 font-semibold text-zinc-950 sm:text-base/6 dark:text-white">New task</h2>
        <!--Fill the form with fake data. Dev mode only-->
        <SecondaryButton v-if="isDevelopment" @click="fillForm">
          <DocumentArrowDownIcon class="size-5" />
        </SecondaryButton>
      </div>

      <form class="mt-6 space-y-6" @submit.prevent="save">
        <div>
          <InputLabel for="title" value="Title" />
          <TextInput
            id="title"
            type="text"
            class="mt-1 block w-full"
            v-model="form.title"
            autofocus
            autocomplete="task_title"
            placeholder="E.g. Take over the world"
          />
          <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
          <InputLabel for="text" value="Text" />
          <TextInput
            id="text"
            multiline
            class="mt-1 block w-full"
            v-model="form.text"
            autocomplete="task_text"
            placeholder="Task additional description"
          />
          <InputError class="mt-2" :message="form.errors.text" />
        </div>

        <div>
          <InputLabel for="date" value="Date" />
          <div class="mt-1 flex gap-2">
            <TextInput id="date" type="date" v-model="form.date" required autocomplete="off" />
            <TextInput id="date" type="time" v-model="form.time" required autocomplete="off" />
          </div>
          <InputError class="mt-2" :message="form.errors.text" />
        </div>

        <div class="flex gap-2">
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create</PrimaryButton>
          <SecondaryLink :href="route('twa.tasks.index')">Cancel</SecondaryLink>
        </div>
      </form>
    </article>
  </TelegramWebAppLayout>
</template>

<script setup>
import TelegramWebAppLayout from '@/Layouts/TelegramWebAppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import { ChevronLeftIcon, DocumentArrowDownIcon } from '@heroicons/vue/16/solid'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { addDays, addHours, formatDate } from 'date-fns'
import SecondaryLink from '@/Components/SecondaryLink.vue'

let tg = window.Telegram.WebApp

// TODO: Figure out why it's 419 after the first precognitive request
let form = useForm('post', route('twa.tasks.store'), {
  title: '',
  text: '',
  date: formatDate(new Date(), 'yyyy-MM-dd'),
  time: formatDate(addHours(new Date(), 1), 'HH:mm'),
  initData: tg.initData,
})

const save = () => form.submit({ only: ['tasks'] })

// Fill the form with fake data (DEV mode only)
const isDevelopment = import.meta.env.DEV
const fillForm = () => {
  const fakeTodos = [
    {
      title: 'Host a Virtual Pet Fashion Show',
      text: 'Dress up your pets in hilarious costumes, stream it live, and let the internet decide who wore it best!',
    },
    {
      title: 'Attempt to Teach Your Cat to Fetch',
      text: 'Grab a ball, some treats, and a lot of patience. Spoiler: the cat might teach you to fetch instead.',
    },
    {
      title: 'Create a DIY Potato Battery',
      text: 'Because why use regular batteries when you have potatoes? Bonus points if you power a light bulb!',
    },
    {
      title: 'Plan a Backyard Sasquatch Hunt',
      text: "Set up a 'Sasquatch' (aka, a friend in a gorilla suit), and organize a hunt. Don’t forget the night-vision goggles!",
    },
    {
      title: 'Bake Unicorn Poop Cookies',
      text: 'Use rainbow dough to make cookies that look like unicorn poop. Taste the magic!',
    },
  ]
  const randomTodoIndex = Math.floor(Math.random() * fakeTodos.length)
  form.title = fakeTodos[randomTodoIndex].title
  form.text = fakeTodos[randomTodoIndex].text
  form.date = formatDate(addDays(new Date(), Math.random() * 10 + 1), 'yyyy-MM-dd')
  form.time = formatDate(addHours(new Date(), Math.random() * 23), 'HH:mm')
}
</script>
