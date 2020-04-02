/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vuex from "vuex";
import axios from "axios";
import auth from "./auth";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import { routes } from "./router";
import storeData from "./store";
import VueSweetalert2 from "vue-sweetalert2";

require("./bootstrap");

window.Vue = require("vue");
Vue.component("app", require("./app.vue"));

// Set vue router
Vue.use(VueRouter);
Vue.use(Vuex);
// Set sweetalert2
Vue.use(VueSweetalert2);

const router = new VueRouter({
  base: "/Sistem-Informasi-Perpustakaan/public",
  history: true,
  mode: "history",
  routes
});

Vue.router = router;

const store = new Vuex.Store(storeData);

import moment from "moment";
Vue.prototype.moment = moment;

// Require vue-moment
Vue.use(require("vue-moment"));

// Require vue-axios
Vue.use(VueAxios, axios);

// Require vue-auth
Vue.use(VueAuth, auth);

axios.defaults.baseURL =
  "http://localhost:3000/Sistem-Informasi-Perpustakaan/public";

// import css
import "sweetalert2/dist/sweetalert2.min.css";

const app = new Vue({
  el: "#app",
  router,
  store
});
