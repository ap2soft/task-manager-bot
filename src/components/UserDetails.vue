<template>
  <p class="text-sm text-[var(--tg-theme-hint-color)]">
    Hello @{{ userData.username ?? '%username%' }}.
  </p>
</template>

<script setup>
let tg = window.Telegram.WebApp
console.log(tg.initDataUnsafe)
console.log(tg.initData)
let userData = tg.initDataUnsafe.user ?? {}
</script>
