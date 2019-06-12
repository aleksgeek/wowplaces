import Vue from 'vue';
import VueLayers from 'vuelayers'
import VueRouter from 'vue-router';
import App from './components/app.vue';
import Registration from './components/registration.vue';
import TouristGuide from './components/tourist-guide.vue';
import PlacesMap from './components/places-map.vue';
import AddPlace from './components/add-place.vue';

import 'vuelayers/lib/style.css'

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: '/add-place', component: AddPlace },
    { path: '/places-map', component: PlacesMap },
    { path: '/tourist-guide', component: TouristGuide },
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
