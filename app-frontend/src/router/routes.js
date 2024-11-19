const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      {
        name: 'cashier-register',
        path: '/cashier-register',
        component: () => import('../modules/CashierRegister/pages/IndexPage.vue'),
        meta: {
          requiresAuth: false
        },
      },
      {
        name: 'cash-management',
        path: '/cash-management',
        component: () => import('../modules/CashManagement/pages/IndexPage.vue'),
        meta: {
          requiresAuth: false
        },
      },
      {
        name: 'transfers',
        path: '/transfers',
        component: () => import('../modules/Transfers/pages/IndexPage.vue'),
        meta: {
          requiresAuth: false
        },
      },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
