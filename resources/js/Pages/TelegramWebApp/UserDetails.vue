<template>
  <div>
    <p class="text-sm text-gray-600 dark:text-gray-400">Hello @{{ userData.username ?? '%username%' }}.</p>
  </div>
</template>

<script setup>
let tg = window.Telegram.WebApp
let userData = tg.initDataUnsafe.user ?? {}
</script>
