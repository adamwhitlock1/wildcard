<template>
  <div class="bg-transparent">
    <nav-bar class="mt-6"></nav-bar>

    <div class="shadow-2xl mt-8 px-3 pb-12 rounded-lg">
      <router-view></router-view>
    </div>

    <footer-row class="mt-8"></footer-row>

  </div>
</template>

<script>
import navBar from './components/navBar'
import footerRow from "./components/footer";
const axios = require('axios');

  export default {
    components: {
      footerRow,
      navBar
    },
    data(){
      return {
        stringExample: "Some Example String Data"
      }
    },
    mounted(){
      console.log("The APP has mounted");
      this.setAllState();
      const tabID = sessionStorage.tabID ? sessionStorage.tabID : sessionStorage.tabID = Math.random();
      if (parseFloat(this.$store.getters['instances/activeInstance'].instanceId) === tabID ) {
        console.log("We have the same activeInstance in vuex");
        console.log(this.$store.getters['instances/activeInstance'].instanceId);
      } else {
        console.log("Active instance does not match or is not declared.");
        console.log(tabID);
        console.log(this.$store.getters['instances/activeInstance'].instanceId);
        const data = { instanceId: tabID, activePanels: [ "left", "center", "right" ] };
        this.$store.commit('instances/setActiveInstancePanels', data);
      }
    },
    methods: {
      setAllState(){
        axios.get('/data').then((res)=>{
          // console.log(res.data);
          this.$store.commit('setAllState', res.data)
        })
      }
    },
    computed: {

    }
  }
</script>

<style scoped>

</style>
