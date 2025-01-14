export const routes = [
  { path: '/', redirect: '/dashboard' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'dashboard',
        component: () => import('@/pages/dashboard.vue'),
      },
      {
        path: 'account-settings',
        component: () => import('@/pages/account-settings.vue'),
      },
      {
        path: '/client/vis-dashboard',
        name: 'vis-dashboard',
        component: () => import('@/pages/visitor/vis-dashboard.vue'),
      },
      {
        path: '/fac-dashboard/:tab?',
        name: 'fac-dashboard',
        component: () => import('@/pages/facility/fac-dashboard.vue'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        component: () => import('@/pages/login.vue'),
      },
      {
        path: 'logout',
        component: () => import('@/pages/logout.vue'),
      },
      {
        path: 'register',
        component: () => import('@/pages/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
      {
        path: 'privacypolicy',
        component: () => import('@/pages/privacypolicy.vue'),
      },
      {
        path: 'termsconditions',
        component: () => import('@/pages/termsconditions.vue'),
      },
    ],
  },
]

