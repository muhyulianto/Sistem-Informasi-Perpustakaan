/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import axios from "axios";
import auth from "./auth";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import router from "./router";
import VueSweetalert2 from "vue-sweetalert2";

require("./bootstrap");

window.Vue = require("vue");

// Set vue router
Vue.router = router;
Vue.use(VueRouter);
// Set sweetalert2
Vue.use(VueSweetalert2);

import moment from "moment";
Vue.prototype.moment = moment;

// Vue.use(require('vue-moment'))
Vue.use(require("vue-moment"));

Vue.use(VueAxios, axios);
Vue.use(VueAuth, auth);

axios.defaults.baseURL =
  "http://localhost/Sistem-Informasi-Perpustakaan/public";
// import css
import "sweetalert2/dist/sweetalert2.min.css";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component("app", require("./app.vue"));

const app = new Vue({
  el: "#app",
  router
});
