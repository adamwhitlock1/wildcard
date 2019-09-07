<template>
  <div class="pt-6">
    <h1 class="text-4xl font-hairline text-center mt-6">Create a custom placeholder</h1>
    <div class="flex">
      <div class="w-1/4">
        Left sidebar
        <button @click="ping">Ping</button>
      </div>
      <div class="w-1/2">
        Canvas section
        <main-canvas style="width: 100%; height: 100%">
          <main-box
            :x1="20"
            :x2="30"
            :y1="100"
            :y2="50"
            :color="chartValues[1].color"
            :value="chartValues[1].val"
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
        chartValues: [
          {val: 24, color: 'red'},
          {val: 32, color: '#0f0'},
          {val: 66, color: 'rebeccapurple'},
          {val: 1, color: 'green'},
          {val: 28, color: 'blue'},
          {val: 60, color: 'rgba(150, 100, 0, 0.2)'},
        ],
        broadcast: null
      }
    },

    // Randomly selects a value to randomly increment or decrement every 16 ms.
    // Not really important, just demonstrates that reactivity still works.
    mounted () {
      this.broadcast = new BroadcastChannel('main-channel');
      this.broadcast.onmessage = e => {
        console.log(e.data);
        this.chartValues[1].val = e.data.val;
      }
    },
    methods: {
      ping(){
        this.broadcast.postMessage({val: 100});
        this.chartValues[1].val = 125
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
