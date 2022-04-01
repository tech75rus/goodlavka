import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../pages/Home')
  },
  {
    path: '/category',
    name: 'Category',
    component: () => import(/* webpackChunkName: "about" */ '../pages/Category')
  },
  {
    path: '/product/:id',
    name: 'Product',
    component: () => import('../pages/Product')
  },
  {
    path: '/favorites',
    name: 'Favorites',
    component: () => import('../pages/Favorites')
  },
  {
    path: '/basket',
    name: 'Basket',
    component: () => import('../pages/Basket')
  },
  {
    path: '/profile',
    name: 'Profile',
    component: () => import('../pages/Profile')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
