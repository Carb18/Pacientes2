import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/auth/Login.vue';
import Home from '@/views/Home.vue';

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresGuest: true }
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: '/',
    redirect: '/home'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Guard de navegación
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth_token');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (to.meta.requiresGuest && isAuthenticated) {
    next('/home');
  } else {
    next();
  }
});

export default router;