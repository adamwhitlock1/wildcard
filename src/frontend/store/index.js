
import Vue from 'vue'
import Vuex from 'vuex'
import items from './modules/mod1'
import instances from './modules/instances'
import VuexPersistence from 'vuex-persist'

let vuexLocal = new VuexPersistence();

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    items,
    instances
  },
  state: {
    dirName: [
      {
        "name": "bird",
        "total": 115
      },
      {
        "name": "bug",
        "total": 62
      },
      {
        "name": "business",
        "total": 0
      },
      {
        "name": "cars",
        "total": 0
      },
      {
        "name": "cat",
        "total": 253
      },
      {
        "name": "dog",
        "total": 269
      },
      {
        "name": "fish",
        "total": 105
      },
      {
        "name": "lion",
        "total": 53
      },
      {
        "name": "tech",
        "total": 0
      },
      {
        "name": "tiger",
        "total": 104
      }
    ],
    totalImages: 961,
    totalUsage: 7
  },
  mutations: {
    setAllState(state, newState) {
      state.dirName = newState.dirName;
      state.totalImages = newState.totalImages;
      state.totalUsage = newState.totalUsage;
    },
    setStateKey(state, key, keyState){

    }
  },
    plugins: [vuexLocal.plugin]
},

)
