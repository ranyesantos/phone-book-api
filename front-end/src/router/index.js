import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '../layouts/AuthLayout.vue';
import MainLayout from '../layouts/MainLayout.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name:AuthLayout,
      component:AuthLayout,
      children: [
        {
          path: '/',
          name: 'login',
          component: () => import('../views/LoginView.vue'),
        },
        {
          path: '/register',
          name: 'register',
          component: () => import('../views/RegisterView.vue')
        },
      ]
    },
    {
      path: '/',
      name:MainLayout,
      component:MainLayout,
      children: [
      
        {
          path: '/home',
          name: 'home',
          component: () => import('../views/HomeView.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/new',
          name: 'newContact',
          component: () => import('../views/contacts/NewContactView.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/contacts/:id',
          name: 'showContact',
          component: () => import('../views/contacts/ShowView.vue'), 
          meta: { requiresAuth: true },
          props: true
        },
        {
          path: '/contacts/:id/edit',
          name: 'editContact',
          component: () => import('../views/contacts/EditView.vue'), 
          meta: { requiresAuth: true },
          props: true 
        },


        {
          path: '/trash-bin',
          name: 'trash-bin',
          component: () => import('../views/TrashBinView.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/trash-bin/:id',
          name: 'showTrashedContact',
          component: () => import('../views/contacts/TrashedContactView.vue'),
          meta: { requiresAuth: true }
        },
      ]
    }

  ]
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('authToken'); 
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router
