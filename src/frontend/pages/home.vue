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
          header="wildcard.codestuff.io/r/{w}/{h}"
          example="/r/250/250"
          example-description="Results in a random critter image at 250px wide by 250px high."
        ></card>
      </div>

      <div class="w-full md:w-1/2 px-4 mt-4">
        <card
          header="wildcard.codestuff.io/{category}/{w}/{h}"
          example="/dog/250/250"
          example-description="Get a categorical image from:  cat, dog, bird, bug, tiger, lion, fish"
        ></card>
      </div>
    </div>
    <p class="text-4xl pt-12 font-hairline w-full text-center">Categories</p>
    <div class="w-full px-4 mt-4">
      <div class="w-full flex flex-wrap">
        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Bird</p>
          <img src="/bird/250/250" alt="Bird" class="w-full h-auto" />
        </div>
        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Bug</p>
          <img src="/bug/250/250" alt="Bug" class="w-full h-auto" />
        </div>


        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Cat</p>
          <img src="/cat/250/250" alt="Cat" class="w-full h-auto" />
        </div>
        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Dog</p>
          <img src="/dog/250/250" alt="Dog" class="w-full h-auto" />
        </div>


        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Fish</p>
          <img src="/fish/250/250" alt="Fish" class="w-full h-auto" />
        </div>
        <div class="w-1/8 p-4 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Lion</p>
          <img src="/lion/250/250" alt="Lion" class="w-full h-auto" />
        </div>


        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Tiger</p>
          <img src="/tiger/250/250" alt="Tiger" class="w-full h-auto" />
        </div>
        <div class="w-1/8 p-3 mt-4">
          <p class="text-2xl font-hairline w-full text-center">Potato</p>
          <img src="/potato/250/250" alt="Potato" class="w-full h-auto" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import card from "../components/card";
import { mapState } from "vuex";
export default {
  components: {
    card
  },
  data() {
    return {
      stringExample: "This is a string."
    };
  },
  computed: mapState({
    totalImages: "totalImages",
    totalUsage: "totalUsage"
  })
};
</script>

<style lang="scss" scoped>
</style>
