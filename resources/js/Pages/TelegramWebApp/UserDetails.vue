<template>
  <div>
    <p class="text-sm text-[var(--tg-theme-hint-color)]">Hello @{{ userData.username ?? '%username%' }}.</p>
    <div>
      <code>{{ tg.initDataUnsafe }}</code>
    </div>
    <div>
      <code>{{ tg.initData }}</code>
    </div>
  </div>
</template>

<script setup>
let tg = window.Telegram.WebApp
let userData = tg.initDataUnsafe.user ?? {}
</script>
