<template>
  <div>
    <p class="text-sm text-[var(--tg-theme-hint-color)]">Hello @{{ userData.username ?? '%username%' }}.</p>
    <div>
      {{ tg.initDataUnsafe }}
    </div>
    <div>
      {{ tg.initData }}
    </div>
  </div>
</template>

<script setup>
let tg = window.Telegram.WebApp
let userData = tg.initDataUnsafe.user ?? {}
</script>
