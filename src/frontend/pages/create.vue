<template>
  <div class="pt-6">
    <h1 class="text-4xl font-hairline text-center mt-6">Create a custom placeholder</h1>
    <div class="flex">
      <div class="w-1/4">
          <p>Left sidebar</p>
          <p v-if="instance">{{ instance }}</p>
        <button @click="ping('testObj', {val: 125, color: 'red'})" class="px-3 py-4 bg-green-500 text-white">Ping</button>
      </div>
      <div class="w-1/2">
        Canvas section
        <main-canvas style="width: 100%; height: 100%">
          <main-box
            :x1="20"
            :x2="30"
            :y1="100"
            :y2="50"
            :color="testObj.color"
            :value="testObj.val"
          />
        </main-canvas>
        <canvas id="editor" class="w-full"></canvas>
      </div>
      <div class="w-1/4">
        Right sidebar


      </div>
    </div>
  </div>
</template>

<script>
  import MainCanvas from "../components/MainCanvas";
  import MainBox from "../components/MainBox";
  export default {
    name: 'app',
    components: {
      MainCanvas,
      MainBox
    },

    data () {
      return {
        testObj: {
          val: 100,
          color: "green"
        },
        broadcast: null,
        instance: null
      }
    },

    // Randomly selects a value to randomly increment or decrement every 16 ms.
    // Not really important, just demonstrates that reactivity still works.
    mounted () {
      this.broadcast = this.$broadcast;
      let now = new Date();
      this.instance = now.getTime();
      this.broadcast.onmessage = event => {
        console.log(event);
        let dataLength = event.data.length;
        for (let i = 0; i < dataLength; i++){
          let keys = Object.keys(event.data[i]);
          let keysLength = keys.length;
          console.log(keysLength);
          for ( let ii = 0; ii < keysLength; ii++){
            this[keys[ii]] = event.data[i][keys[ii]];
          }
        }
      }
    },
    methods: {
      ping(obj, val){
        let postObj = {};
        postObj[obj] = val;
        this.broadcast.postMessage([postObj]);
        this[obj] = val;
      },

    }
  }
</script>

<style>
  html, body {
    margin: 0;
    padding: 0;
  }

  #app {
    position: relative;
    height: 100vh;
    width: 100vw;
    padding: 20px;
    box-sizing: border-box;
  }
</style>
