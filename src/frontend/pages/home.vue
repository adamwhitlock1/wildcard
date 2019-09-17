<template>
  <div>
    <p class="text-4xl pt-12 font-hairline w-full text-center">
      A placeholder service for {{ totalImages }} free images.
    </p>
    <div class="w-full pb-4 px-8 mb-2 mt-0 text-center">
      <p class="font-light">served over {{ totalUsage }} times</p>
    </div>
    <div class="block md:flex -mx-4">

      <div class="w-full md:w-1/2 px-4 mt-4">
        <card
                header='wildcard.fun/r/{w}/{h}'
                example="/r/250/250"
                example-description="Results in a random critter image at 250px wide by 250px high."
        ></card>
      </div>

      <div class="w-full md:w-1/2 px-4 mt-4">
        <card
                header="wildcard.fun/{category}/{w}/{h}"
                example="/dog/250/250"
                example-description="Get a categorical image from:  cat, dog, bird, bug, tiger, lion, fish"
        ></card>
      </div>
    </div>

  </div>
</template>

<script>
import card from "../components/card"
import { mapState } from "vuex";
  export default {
    components: {
      card
    },
    data() {
      return {
        stringExample: "This is a string."
      }
    },
    computed: mapState({
      totalImages: 'totalImages',
      totalUsage: 'totalUsage'
      })
  }
</script>

<style lang="scss" scoped>

</style>
