import Vue from "vue";
import Router from "vue-router";
import Home from "../pages/home";
import About from "../pages/about";
import Create from "../pages/create";

Vue.use(Router);

export default new Router({
  routes: [
    { path: "/", component: Home },
    { path: "/about", component: About },
    { path: "/create", component: Create }
  ]
});
