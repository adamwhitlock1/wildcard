import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import router from './router'
import store from './store'
import App from './App.vue'

import VueDraggableResizable from 'vue-draggable-resizable'

// optionally import default styles
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'

Vue.prototype.$broadcast = new BroadcastChannel('main');
Vue.component('vue-draggable-resizable', VueDraggableResizable)

new Vue({
  el: '#wildcard-app',
  router,
  store,
  render: h => h(App)
})

console.log("FRONTEND IS!");
