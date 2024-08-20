import { createRouter, createWebHistory } from 'vue-router';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
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
