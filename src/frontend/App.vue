<template>
  <div class="bg-transparent">
    <nav-bar class="mt-6"></nav-bar>

    <div class="shadow-2xl mt-8 px-6 pb-12 rounded-lg">
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
      setInterval(()=>{
        this.setAllState()
      }, 5000)
    },
    methods: {
      setAllState(){
        axios.get('/data').then((res)=>{
          console.log(res.data);
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
