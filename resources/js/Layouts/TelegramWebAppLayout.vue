<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-dvh bg-gray-100 pt-6 dark:bg-gray-900">
    <div class="mx-auto sm:max-w-lg">
      <div class="flex justify-center">
        <Link href="./">
          <ApplicationLogo class="size-12 fill-current text-gray-500" />
        </Link>
      </div>

      <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-lg sm:rounded-lg dark:bg-gray-800">
        <slot />
      </div>
    </div>
  </div>
</template>
