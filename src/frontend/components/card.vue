<template>
    <div class="p-6 bg-gray-200 border-b-4 border-gray-400 text-white rounded-lg shadow-lg flex">

      <div class="w-1/2">
        <img class="rounded shadow-lg" :src="example"/>
      </div>

      <div class="w-1/2 p-1 flex-no-wrap">

        <h3 class="w-full text-green-600 text-sm tracking-tight font-mono text-center">{{ header }}</h3>

        <div class="mt-3 text-gray-100 bg-green-700 h-30 rounded font-light px-4 py-3 border-green-300 border-b-4 shadow-lg">
          <p class="w-full mt-1 font-black text-green-200 text-sm">Ex: <a :href="'https://wildcard.fun' + example" target="_blank" class="underline">wildcard.fun{{example}}</a></p>
          <p class="font-light align-baseline text-xs">{{ exampleDescription }}</p>
        </div>

      </div>

    </div>
</template>

<script>
  import {mapState} from 'vuex';
  export default {
    name: "compExample",
    props: {
      header: {
        type: String,
        default: "heading"
      },
      description: {
        type: String,
        default: "description"
      },
      example: {
        type: String,
        default: "wildcard.fun/r/200/300"
      },
      exampleDescription: {
        type: String,
        default: "ex description"
      }
    },
    computed: {
      ...mapState['urlString']
    }
  }
</script>

<style scoped>

</style>
