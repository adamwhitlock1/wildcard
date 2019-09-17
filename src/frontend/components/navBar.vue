<template>
  <div>
    <div class="flex text-center">
      <div class="w-1/4 text-center content-center">
        <img class="w-2/3 mx-auto" src="/public/WildcardLogo.png">
      </div>
      <div
        class="w-3/4 py-4 mt-1 bg-blue-900 border-b-4 border-blue-300 border-solid rounded-lg"
      >
        <div class="flex">
          <div class="w-full text-right px-4">
            <router-link
              class="border-b-2 border-solid border-white p-1 mx-4 text-base font-black text-blue-200 hover:text-white border-blue-200 hover:border-white leading-none"
              to="/"
            >
              home
            </router-link>
            <router-link
              class="border-b-2 border-solid border-white p-1 mx-4 text-base font-black text-blue-200 hover:text-white border-blue-200 hover:border-white leading-none"
              to="/about"
            >
              about
            </router-link>
<!--            <router-link-->
<!--              class="border-b-2 border-solid border-white p-1 mx-4 text-base font-black text-blue-200 hover:text-white border-blue-200 hover:border-white leading-none"-->
<!--              to="/create"-->
<!--            >-->
<!--              create-->
<!--            </router-link>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {};
  },
  computed: mapState({
    totalImages: state => state.totalImages
  })
};
</script>

<style scoped>
</style>
