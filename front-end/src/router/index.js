import { createRouter, createWebHistory } from 'vue-router'
import Index from '../views/Index.vue'
import Rules from '../views/Rules.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/rules',
      name: 'rules',
      component: Rules
    },
  ]
})

export default router
