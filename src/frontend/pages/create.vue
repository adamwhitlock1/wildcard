<template>
  <div class="pt-1 h-screen">
    <h1 class="text-4xl font-hairline text-center">Create a custom placeholder</h1>

    <!-- rotated tabs for closed columns-->
    <p class="left bg-green-500 w-40 text-white py-1 text-sm flipped text-center rounded"
       :class="{'opacity-100': !isShowing.left, 'opacity-0 tab-hidden': isShowing.left }"
       @click="closePanel('left')">
      Properties
    </p>

    <p class="center bg-blue-500 w-40 text-white py-1 text-sm flipped text-center rounded"
       :class="{'opacity-100': !isShowing.center, 'opacity-0 tab-hidden': isShowing.center}"
       @click="closePanel('center')">
      Image Preview
    </p>

    <p class="right bg-purple-500 w-40 text-white py-1 text-sm flipped text-center rounded"
       :class="{'opacity-100': !isShowing.right, 'opacity-0 tab-hidden': isShowing.right}"
       @click="closePanel('right')">
      Layout
    </p>

    <div class="flex">

      <!-- column for PROPERTIES-->
      <div class="overflow-hidden rounded-lg"
           :class="{
           'w-0': !isShowing.left && !isShowing.right,
           'w-1/4': isShowing.left || isShowing.right,
           'ml-12': !isShowing.right || !isShowing.center || !isShowing.left,
           'w-full': isShowing.left && !isShowing.center
           }">

        <div :class="{'h-0 w-0 opacity-0': !isShowing.left}" class="p-2 bg-green-100">
          <div class="bg-green-500 py-1 px-4 text-white text-sm w-48 rounded"
             @click="closePanel('left')">
            < Properties
          </div>

        <button @click="ping('testObj', {val: 125, color: 'red'})" class="px-3 py-4 bg-red-500 mt-3 text-white">Ping</button>

          <input type="number" v-model="num">
          <input type="color" v-model="fill">

          <input type="text" v-model="text">

          {{ fill }}
        </div>

        <!-- column for LAYOUT-->
        <div class="bg-purple-100 overflow-hidden rounded-lg shadow-md mt-2"
             :class="{
              'w-0 h-0': !isShowing.right,
              'w-full': isShowing.left && isShowing.center && isShowing.right,
              'w-full': (isShowing.left && isShowing.right) || (isShowing.center && isShowing.right),
              'w-full': !isShowing.left && !isShowing.center && isShowing.right,
              'ml-4': !isShowing.left || !isShowing.center,
              }">

          <div :class="{'h-0 w-0': !isShowing.right}" class="h-full p-2">
            <div class="bg-purple-500 py-1 px-4 text-white text-sm w-48 rounded"
                 @click="closePanel('right')">
              < Layout
            </div>

            <button @click="ping('testObj', {val: 125, color: 'red'})" class="px-3 py-4 bg-red-500 mt-3 text-white">Ping</button>

          </div>

        </div>

      </div>

      <div class="ml-4 bg-blue-100 overflow-hidden rounded-lg shadow"
           :class="{
           'w-0 h-0': !isShowing.center,
           'w-3/4': (isShowing.left && isShowing.center && isShowing.right) || (isShowing.center && isShowing.right) || (isShowing.center && isShowing.left),
           'w-full': !isShowing.left && !isShowing.right && isShowing.center,
           'ml-12': (!isShowing.left && isShowing.center && isShowing.right) || (isShowing.left && isShowing.center && !isShowing.right),
           }">
        <div :class="{'h-0': !isShowing.center}" class="h-full p-2">
          <div class="bg-blue-500 py-1 px-4 text-white text-sm w-48 rounded"
               @click="closePanel('center')">
            < Image Preview
          </div>

          <div class="pt-3" :class="{'h-0 w-0': !isShowing.center, 'w-full': isShowing.center }">
            <div style="height: 500px; width: 1200px; border: 1px solid black; position: relative; background-image: url('https://wildcard.fun/r/1200/1200'); background-position: top center; background-size: cover" id="outer-frame">
              <vue-draggable-resizable :w="100" :h="100" @dragging="onDrag" @resizing="onResize" parent="#outer-frame" className="text-layer">
                <p>{{ testObj.val }}</p>
              </vue-draggable-resizable>
            </div>

          </div>
        </div>
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
        isShowing: {
          left: true,
          center: true,
          right: true
        },
        width: 0,
        height: 0,
        x: 0,
        y: 0,
        isBound: true,
        frameWidth: 100,
        num: "100",
        fill: null,
        testObj: {
          val: "100",
          color: "green"
        },
        text: "none",
        broadcast: null,
        instance: null
      }
    },

    // Randomly selects a value to randomly increment or decrement every 16 ms.
    // Not really important, just demonstrates that reactivity still works.
    mounted () {
      this.broadcast = this.$broadcast;
      var tabID = sessionStorage.tabID ? sessionStorage.tabID : sessionStorage.tabID = Math.random();
      this.$store.commit('instances/setActiveInstancePanels',
              {
                instanceId: tabID,
                activePanels: ["center"]
              });
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
      onResize: function (x, y, width, height) {
        this.x = x
        this.y = y
        this.width = width
        this.height = height
      },
      onDrag: function (x, y) {
        this.x = x
        this.y = y
      },
      closePanel(side){
        this.isShowing[side] = !this.isShowing[side];
        let newFrame = document.querySelector("#outer-frame").clientWidth;
        this.frameWidth = newFrame;
        setTimeout(()=>{
          console.log(newFrame);
          this.isBound = true;
        }, 2000)
      }

    },
    watch: {
      num(value) {
        console.log("num changed to " + value);
        this.ping('testObj', {val: value, color: `${this.fill}`})
      },
      fill(value) {
        this.ping('testObj', {val: this.num, color: `${value}`})
      }
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


  .flipped {
    transform: rotate(90deg) translateY(10px);
    left: -25px;
    position: fixed;
  }

  .tab-hidden {
    transform: rotate(90deg) translateY(50px);
  }

  .left {
    top: 30%
  }

  .center {
    top: 55%;
  }

  .right {
    top: 80%
  }

  .w-3\/4.ml-12 #outer-frame {
    transform: scale(.75);
    transform-origin: top left;
  }
  .w-3\/4 #outer-frame {
    transform: scale(.8);
    transform-origin: top left;
  }

  * {
    transition: 0.4s;
  }

  .active {
    border: 2px dotted cornflowerblue;
    transition: 0s;
  }
</style>
