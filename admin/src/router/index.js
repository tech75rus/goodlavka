import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from "../views/Login";
import Registration from "../views/Registration";
import ProductView from "../components/products/ProductView";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    meta: {
      layout: 'main',
      success: false
    },
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    meta: {
      layout: 'main',
      success: false
    },
    component: () => import('../views/About.vue')
  },
  {
    path: '/products',
    name: 'Product',
    testFunction() {
      return this.$store.getters.getToken
    },
    meta: {
      layout: 'main',
      success: false
    },
    component: () => import('../views/ProductList')
  },
  {
    path: '/add-product',
    name: 'AddProduct',
    meta: {
      layout: 'main',
      success: ['ROLE_ADMIN']
    },
    component: () => import('../views/AddProduct.vue')
  },
  {
    path: '/registration',
    name: 'Registration',
    meta: {
      layout: 'empty',
      success: true
    },
    component: Registration
  },
  {
    path: '/login',
    name: 'Login',
    meta: {
      layout: 'empty',
      success: true
    },
    component: Login
  },
  {
    path: '/product-view/:id',
    name: 'ProductView',
    meta: {
      layout: 'main',
      success: true
    },
    component: ProductView
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
  VueRouter
})

export default router
