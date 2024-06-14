<template>
  <div>
    <p class="text-sm text-[var(--tg-theme-hint-color)]">Hello @{{ userData.username ?? '%username%' }}.</p>
    <code>{{ tg.initDataUnsafe }}</code>
    <code>{{ tg.initData }}</code>
  </div>
</template>

<script setup>
let tg = window.Telegram.WebApp
let userData = tg.initDataUnsafe.user ?? {}
</script>
