Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'real-estate',
      path: '/real-estate',
      component: require('./components/Tool'),
    },
  ])
})
