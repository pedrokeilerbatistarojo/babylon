const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    meta: {
      requiresAuth: true,
    },
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      {
        name: 'cashier-register',
        path: '/cashier-register',
        component: () => import('../modules/CashierRegister/pages/IndexPage.vue'),
        meta: {
          requiresAuth: true
        },
      },
      {
        name: 'cash-management',
        path: '/cash-management',
        component: () => import('../modules/CashManagement/pages/IndexPage.vue'),
        meta: {
          requiresAuth: true
        },
      },
      {
        name: 'transfers',
        path: '/transfers',
        component: () => import('../modules/Transfers/pages/IndexPage.vue'),
        meta: {
          requiresAuth: true
        },
      },
    ]
  },
  {
    name: 'login',
    path: '/login',
    component: () => import('../modules/Auth/pages/LoginPage.vue'),
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
