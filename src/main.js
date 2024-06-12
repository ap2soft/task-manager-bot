import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')

// Hide the page loading animation after the app is mounted
window.addEventListener('load', () => {
  const pageLoadingSpinner = document.getElementById('page-loading')
  if (pageLoadingSpinner) {
    pageLoadingSpinner.style.display = 'none'
  }
})
