import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/app.vue';
import Registration from './components/registration.vue';

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: '/add-place', component: Registration },
    { path: '/places-map', component: Registration },
    { path: '/tourist-guide', component: Registration },
    { path: '/registration', component: Registration }
  ]
})

new Vue({
  router,
  el: '#app',
  data:{
  },
  render: h => h(App)
})
