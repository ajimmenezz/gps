export default
[
  {
    path: '/test',
    component: () => import('@/views/test/test.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '/test/localStorage',
        name: 'localStorage',
        component: () => import('@/views/test/LocalStorage')
      },
      {
        path: '/test/api',
        name: 'testApi',
        component: () => import('@/views/test/MixinApi')
      },
      {
        path: '/test/loadImg',
        name: 'loadImg',
        component: () => import('@/views/test/loadImg')
      },
      {
        path: '/test/dynamic/component',
        name: 'dynamicComponent',
        component: () => import('@/views/test/dynamicRender')
      },
      {
        path: '/test/map',
        name: 'testMap',
        component: () => import('@/views/test/Map')
      },
      {
        path: '/test/moment',
        name: 'testMoment',
        component: () => import('@/views/test/moment')
      },
      {
        path: '/test/datepicker',
        name: 'datePicker',
        component: () => import('@/views/test/datetimepicker')
      },
      {
        path: '/test/loader/small',
        name: 'loaderSmall',
        component: () => import('@/views/test/loaderSmall')
      },
      {
        path: '/test/mapmodule/',
        component: () => import('@/views/test/MapModule/main')
      },
      {
        path: '/test/resize/',
        component: () => import('@/views/test/resize/main')
      },
      {
        path: '/test/upload/',
        component: () => import('@/views/test/uploadFile')
      },
      {
        path: '/test/datatable/',
        component: () => import('@/views/test/DataTable/DataTableExample')
      },
      {
        path: '*',
        redirect: { path: '/test/localStorage' }
      }
    ]
  }
]
