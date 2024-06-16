<template>
  <nav v-if="links.length > 3" class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
    <div class="-mt-px flex w-0 flex-1">
      <Link
        :href="prevLink"
        class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:border-gray-600 dark:hover:text-gray-300"
      >
        <ArrowLongLeftIcon class="mr-3 size-5 text-gray-500" aria-hidden="true" />
        Previous
      </Link>
    </div>

    <div class="hidden md:-mt-px md:flex">
      <Link
        v-for="page in pages"
        :key="page.label"
        :href="page.url"
        class="inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium"
        :class="[
          page.active
            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-500'
            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:border-gray-600 dark:hover:text-gray-300',
        ]"
      >
        {{ page.label }}
      </Link>
    </div>

    <div class="-mt-px flex w-0 flex-1 justify-end">
      <Link
        :href="nextLink"
        class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:border-gray-600 dark:hover:text-gray-300"
      >
        Next
        <ArrowLongRightIcon class="ml-3 size-5 text-gray-500" aria-hidden="true" />
      </Link>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ArrowLongLeftIcon, ArrowLongRightIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  links: Array,
})

const prevLink = computed(() => props.links[0]?.url)
const nextLink = computed(() => props.links[props.links.length - 1]?.url)
const pages = computed(() => props.links.slice(1, -1))
</script>
