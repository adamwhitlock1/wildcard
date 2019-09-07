import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import router from './router'
import store from './store'
import App from './App.vue'


Vue.prototype.$broadcast = new BroadcastChannel('main');

new Vue({
  el: '#wildcard-app',
  router,
  store,
  render: h => h(App)
})

console.log("FRONTEND IS!");
